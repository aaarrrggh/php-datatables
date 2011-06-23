<?php

abstract class DataTable_DataSource{

	/**
   * Load data for an AJAX request
   * 
   * This method must return a DataTable_DataResult object
   * 
   * @param DataTable_ServerParameterHolder $parameters
   * @return DataTable_DataResult
   */
	abstract public function loadData(DataTable_Request $request);
	
	/*
	 * Return the total number of entities returned after calling the loadData function
	 */
	protected final function getTotalNumberOfEntities(array $entities){
		foreach ($entities as $entity){
			if (!$entity instanceof DataTable_DataEntity){
				throw new DataTable_DataTableException('Not an entity type!');
			}
		}
		return count($entities);
	}
}