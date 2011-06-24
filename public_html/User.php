<?php

class User extends DataTable_DataEntity{
	
	protected $_firstName = null;
	protected $_lastName = null;
	protected $_username = null;
	

	
	/* (non-PHPdoc)
	 * @see DataTable_DataEntity::init()
	 */
	public function init($mysqlResultRow) {
		$this->_firstName = $mysqlResultRow['first_name'];
		$this->_lastName = $mysqlResultRow['last_name'];
		$this->_username = $mysqlResultRow['username']; 
		
	}

	public function getFirstName(){
		return $this->_firstName;
	}
	
	public function getLastName(){
		return $this->_lastName;
	}
	
	public function getUsername(){
		return $this->_username;
	}
	
}