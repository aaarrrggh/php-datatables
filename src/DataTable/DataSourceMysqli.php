<?php

class DataTable_DataSourceMysqli extends DataTable_DataSource{
	
	protected $_db = null;
	protected $_databaseTablesToQuery = array();
	protected $_whereClauseAdditions = array();
	 
	
	
	public function __construct(DataTable_Config $config, $entityObjectName, mysqli $dbConnection, array $dbTableNames){
		$this->_db = $dbConnection;
		$this->_config = $config;
		$this->_entityObjectName = $entityObjectName;
		
		$this->setDbTableNames($dbTableNames);
		
	}

	protected function setDbTableNames($dbTableNames){
			
		$dat = $this->_db->query('SHOW TABLES LIKE "'.mysqli_real_escape_string($this->_db, implode(',', $dbTableNames)).'"');	
		
		if ($dat->num_rows !== count($dbTableNames)){
			throw new DataTable_DataTableException('At least one database table does not exist: '. $dbTableNames);
		}
		
		$this->_databaseTablesToQuery = $dbTableNames;
	}
	
	public function loadData(DataTable_Request $request) {
		
		if (is_null($this->_db)){
			throw new DataTable_DataTableException('You need to initialise the database via the setDatabaseConnection() method!');
		}
	
	
	$results = array();

	$results = $this->getEntities($request);

    return new DataTable_DataResult($results, $this->getTotalNumberOfRecordsInDataSet(), $this->getTotalNumberOfFilteredResults($request, $results)); //the pagination requires filtered
		
		
	}
	


	protected function getTotalNumberOfRecordsInDataSet() {
		$query = 'SELECT Count(id) as id FROM '.mysqli_real_escape_string($this->_db, implode(',', $this->_databaseTablesToQuery));

		if (count($this->_whereClauseAdditions) > 0){
			$query .= ' WHERE '.implode(' AND ', $this->_whereClauseAdditions);
		}
	
		$dat = $this->_db->query($query);
		
		$result = $dat->fetch_assoc();
		return $result['id'];
	}

	protected function getEntities(DataTable_Request $request){
		
		$dat = $this->_db->query($this->_generateSqlQuery($request));
	
		$entities = array();
		while ($row = $dat->fetch_assoc()){
			$entities[] = DataTable_DataEntityFactory::create($this->_entityObjectName, $row);
		}
		
		return $entities;
	}
	
	private function _getSearchElementOfSqlQuery(DataTable_Request $request){
		
		$whereClause = '';
		
		
		if (!is_null($request->getSearch()) && strlen($request->getSearch()) > 0){
			$whereClause .= 'WHERE ';
			
			
			
			$x = 0;
			$numberSearchItems = count ($this->getSearchableColumnNames());
			
			foreach ($this->getSearchableColumnNames() as $columnName){
				
				if ($x==0){
					//first time in where loop for search term
					$whereClause .= '(';
				}
				
				if ($x>0){
					$whereClause .= ' OR ';
				}
				
				$whereClause .= $columnName .' LIKE "%'. mysqli_real_escape_string($this->_db, $request->getSearch()) .'%"';
				
				$x++;
				
				if ($x == $numberSearchItems){
					$whereClause .= ')';
				}
			}
			
			
			foreach ($this->_whereClauseAdditions as $userWhereClause){
				$whereClause .= ' AND '.$userWhereClause;
			}
			
			
			
		}else{
			
			$firstTimeInWhereLoop = true;
			
			foreach ($this->_whereClauseAdditions as $userWhereClause){
					
					if ($firstTimeInWhereLoop){
						$whereClause .= ' WHERE '.$userWhereClause;
						$firstTimeInWhereLoop = false;
					}else{
						$whereClause .= ' AND '.$userWhereClause;
					}
				
					
				}
		}
		
		
				
		return $whereClause;
	}
	
	private function _getOrderByElementOfSqlQuery(DataTable_Request $request){
		
		return 'ORDER BY '.mysqli_real_escape_string($this->_db, $this->_config->getColumns()->get($request->getSortColumnIndex())->getSortKey()) .' '.$request->getSortDirection();
	}
	
	private function _generateSqlQuery(DataTable_Request $request){
		
		
		$whereClause = $this->_getSearchElementOfSqlQuery($request);
		
		$orderBy = $this->_getOrderByElementOfSqlQuery($request);
		
	
		$query = 'SELECT * FROM '.mysqli_real_escape_string($this->_db, implode(',', $this->_databaseTablesToQuery)).' '.$whereClause.' '. $orderBy . '  LIMIT '.$request->getDisplayStart().', '.$request->getDisplayLength();	
		
		//echo $query;
		return $query;
	}

	
	
	public function setDbTablesToQuery(array $dbTables){
		$this->_setDbTableNames($dbTables);
	}
	
	public function addWhereClause($whereClause){
		$this->_whereClauseAdditions[] = $whereClause;
	}
	
}