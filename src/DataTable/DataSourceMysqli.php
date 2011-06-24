<?php

class DataTable_DataSourceMysqli extends DataTable_DataSource{
	
	protected $_db = null;
	
	public function __construct(DataTable_Config $config, mysqli $dbConnection){
		$this->_db = $dbConnection;
		$this->_config = $config;
	}

	
	public function loadData(DataTable_Request $request) {
		
		if (is_null($this->_db)){
			throw new DataTable_DataTableException('You need to initialise the database via the setDatabaseConnection() method!');
		}
	
	
	$results = array();

	$results = $this->getEntities($request);
	
	
    return new DataTable_DataResult($results, $this->getTotalNumberOfRecordsInDataSet(), $this->getTotalNumberOfFilteredResults($results));
		
		
	}
	

	/* (non-PHPdoc)
	 * @see DataTable_DataSource::getResults()
	 */
	protected function getResults(DataTable_Request $request) {
		// TODO Auto-generated method stub
		
	}

	protected function getTotalNumberOfRecordsInDataSet() {
		$dat = $this->_db->query('SELECT Count(id) as id FROM users');
		$result = $dat->fetch_assoc();
		return $result['id'];
	}

	
	
	protected function search(DataTable_Request $request, $sortKey, $searchableColumns){
	
	/*	$searchTerm = $request->getSearch();
		$query = 'SELECT '.implode(',', $this->getAllColumnNames()).' FROM users WHERE '
		*/
	}
	

	
	protected function getEntities(DataTable_Request $request){
		
		$dat = $this->_db->query($this->_generateSqlQuery($request));
	
		$entities = array();
		while ($row = $dat->fetch_assoc()){
			$entities[] = new User($row['first_name'], $row['last_name'], $row['username']);
		}
		
		return $entities;
	}
	
	private function _getSearchElementOfSqlQuery(DataTable_Request $request){
		
		$whereClause = '';
		
		
		if (!is_null($request->getSearch()) && strlen($request->getSearch()) > 0){
			$whereClause .= 'WHERE ';
			
			$x = 0;
			foreach ($this->getSearchableColumnNames() as $columnName){
				
				if ($x>0){
					$whereClause .= ' OR ';
				}
				
				$whereClause .= $columnName .' LIKE "%'. mysqli_real_escape_string($this->_db, $request->getSearch()) .'%"';
				
				$x++;
			}
			
		}
				
		return $whereClause;
	}
	
	
	
	private function _generateSqlQuery(DataTable_Request $request){
		
		
		$whereClause = $this->_getSearchElementOfSqlQuery($request);
		
	
		$query = 'SELECT * FROM users '.$whereClause.'
					ORDER BY '.mysqli_real_escape_string($this->_db, $this->_config->getColumns()->get($request->getSortColumnIndex())->getSortKey()) .' '.$request->getSortDirection() .
					' LIMIT '.$request->getDisplayStart().', '.$request->getDisplayLength();	
		
	
		
		return $query;
	}

	
}