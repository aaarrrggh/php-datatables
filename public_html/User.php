<?php

class User extends DataTable_DataEntity{
	
	protected $_firstName = null;
	protected $_lastName = null;
	protected $_username = null;
	
	
	public function __construct($firstName, $lastName, $username){
		$this->_firstName = $firstName;
		$this->_lastName = $lastName;
		$this->_username = $username;
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