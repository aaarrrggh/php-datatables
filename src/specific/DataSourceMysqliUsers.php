<?php 

class DataSourceMysqliUsers extends DataTable_DataSourceMysqli{
	
	
	
	public function setDbTablesToQuery(array $dbTables){
		$this->_databaseTablesToQuery = $dbTables;
	}
	
	public function addWhereClause($whereClause){
		$this->_whereClauseAdditions[] = $whereClause;
	}
}

?>