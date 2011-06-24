<?php
/*
 * A DataEntity represents whatever entity you are trying to display in the table
 * 
 */

abstract class DataTable_DataEntity{
	
	final public function __construct(array $mysqlResultRow){
		
		//TODO: intraspection of the class to match class properties to the mysql result
		$this->init();
	}
	
	/**
	 * 
	 * This is a hook to allow people to still execute code when the object is first created
	 * despite having locked down the constructor
	 */
	abstract public function init();
	
}