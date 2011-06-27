<?php

class DataTable_DataSourceMysqli extends DataTable_DataSource{
	
	protected $_db = null;
	protected $_dbTableName = null;
	
	public function __construct(DataTable_Config $config, mysqli $dbConnection, $dbTableName){
		$this->_db = $dbConnection;
		$this->_config = $config;
		$this->setDbTableName($dbTableName);
		
	}

	protected function setDbTableName($dbTableName){
		$dat = $this->_db->query('SHOW TABLES LIKE "'.mysqli_real_escape_string($this->_db, $dbTableName).'"');	
		
		if ($dat->num_rows <= 0){
			throw new DataTable_DataTableException('Database table does not exist: '. $dbTableName);
		}
		
		$this->_dbTableName = $dbTableName;
	}
	
	public function loadData(DataTable_Request $request) {
		
		if (is_null($this->_db)){
			throw new DataTable_DataTableException('You need to initialise the database via the setDatabaseConnection() method!');
		}
	
	
	$results = array();

	$results = $this->getEntities($request);

    return new DataTable_DataResult($results, $this->getTotalNumberOfRecordsInDataSet(), $this->getTotalNumberOfFilteredResults($request, $results)); //the pagination requires filtered		
		
	}
	

	/* (non-PHPdoc)
	 * @see DataTable_DataSource::getResults()
	 */
	protected function getResults(DataTable_Request $request) {
		// TODO Auto-generated method stub
		
	}

	protected function getTotalNumberOfRecordsInDataSet() {
		$dat = $this->_db->query('SELECT Count(id) as id FROM '.$this->_dbTableName);
		$result = $dat->fetch_assoc();
		return $result['id'];
	}

	protected function getEntities(DataTable_Request $request){
		
		$dat = $this->_db->query($this->_generateSqlQuery($request));
	
		$entities = array();
		while ($row = $dat->fetch_assoc()){
			$entities[] = DataTable_DataEntityFactory::create('User', $row);
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
	
	private function _getOrderByElementOfSqlQuery(DataTable_Request $request){
		
		return 'ORDER BY '.mysqli_real_escape_string($this->_db, $this->_config->getColumns()->get($request->getSortColumnIndex())->getSortKey()) .' '.$request->getSortDirection();
	}
	
	private function _generateSqlQuery(DataTable_Request $request){
		
		
		$whereClause = $this->_getSearchElementOfSqlQuery($request);
		
		$orderBy = $this->_getOrderByElementOfSqlQuery($request);
		
	
		$query = 'SELECT * FROM '.$this->_dbTableName.' '.$whereClause.' '. $orderBy . '  LIMIT '.$request->getDisplayStart().', '.$request->getDisplayLength();	
		
	
		
		return $query;
	}

	
}