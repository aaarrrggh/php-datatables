<?php

class DataTable_DataEntityFactory{
	
	/**
	 * 
	 * Enter description here ...
	 * 
	 * @return DataTable_DataEntity
	 */
	public static function create($objectName, array $mysqlResultRow){
		
		$obj = new $objectName($mysqlResultRow);
		
		if (!$obj instanceof DataTable_DataEntity){
			throw new DataTable_DataTableException('Must be an instance of DataTable_DataEntity');
		}
		
		return $obj;
	}
	
}