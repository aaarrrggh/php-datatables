<?php
require 'EntityGenerator.php';

class DBManager{
	
	protected $_db = null;
	
	public function __construct(mysqli $connection){
		$this->_db = $connection;
		
	}
	
	public function getDBTableNames(){
		$dat = $this->_db->query('SHOW TABLES');
		
		$result = array();
		
		while ($row = $dat->fetch_array()){	
			$result[] = $row[0];
		}
		
		return $result;
	}
	
	public function generateEntityObjectForTable($tableName){
		if (!$this->_checkTableNameExistsInDB($tableName)){
			throw new Exception('Database table name does not exist');
		}
		
		$columns = $this->_getColumnNames($tableName);
		
		return EntityGenerator::generateEntity($tableName, $columns);
	}
	

	
	protected function _getColumnNames($tableName){
		$dat = $this->_db->query('SHOW COLUMNS FROM '.mysqli_real_escape_string($this->_db, $tableName));
		
		$result = array();
		
		while ($row = $dat->fetch_assoc()){
			array_push($result, $row['Field']);
		}
		
		return $result;
	}
	
	protected function _checkTableNameExistsInDB($tableName){
		$dat = $this->_db->query('SHOW TABLES LIKE "'.mysqli_real_escape_string($this->_db, $tableName).'"');	
		
		if ($dat->num_rows === 0){
			return false;
		}
		
		return true;
	}


	
}