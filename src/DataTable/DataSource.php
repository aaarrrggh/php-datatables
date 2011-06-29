<?php

abstract class DataTable_DataSource{

	protected $_config;
	protected $_entityObjectName;
	
	public function __construct(DataTable_Config $config, $entityObjectName){
		$this->_config = $config;
		$this->_entityObjectName = $entityObjectName;
	}
	
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
	 * Return the total number of records in the dataset - whether it's the database, or a csv etc
	 */
	abstract protected function getTotalNumberOfRecordsInDataSet();
	
	/**
	 * 
	 * Returns the number of results after a search
	 * 
	 */
	protected function getTotalNumberOfFilteredResults(DataTable_Request $request){
		
		if (!$request->getSearch()){
			return null;
		}
		
		
	}
	
	/**
	 * 
	 * Actually does the query. Returns an array of DataTable_DataTableEntity objects
	 * @param DataTable_Request $request
	 * @return array
	 */
	abstract protected function getEntities(DataTable_Request $request);

  /**
   * Utility method to get all the column names 
   * that are configured as being searchable
   * 
   * @return array
   */
  protected function getSearchableColumnNames()
  {
    $cols = array();
    
    foreach($this->_config->getColumns() as $column){
    	    
      if($column->isSearchable()){
        $cols[] = $column->getName();
      }
    }
    
    return $cols;
  }
  
  protected function getAllColumnNames(){
  	
  	$cols = array();
    
    foreach($this->_config->getColumns() as $column){
    	   
        $cols[] = $column->getName();
   
    }
    
    return $cols;
  }
    
  protected function getSearchSortKey(DataTable_Request $request){
  	return $this->_config->getColumns()->get($request->getSortColumnIndex())->getSortKey();
  }
}