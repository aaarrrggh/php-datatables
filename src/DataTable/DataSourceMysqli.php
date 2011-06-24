<?php

class DataTable_DataSourceMysqli extends DataTable_DataSource{
	
	protected $_db = null;
	
	public function __construct(mysqli $dbConnection){
		$this->_db = $dbConnection;
	}

	/**
	 * 
	 * @return DataTable_DataResult
	 */
	public function loadData(DataTable_Request $request) {
		if (is_null($this->_db)){
			throw new DataTable_DataTableException('You need to initialise the database via the setDatabaseConnection() method!');
		}
		
	$results = $this->getResults($request);	
		
	



    // get the count of the filtered results
    $filteredTotalLength = count($results);
    
    // sort results by sort column passed in
    //$this->sortObjectArray($this->config->getColumns()->get($request->getSortColumnIndex())->getSortKey(), $results, $request->getSortDirection());

    // limit the results based on parameters passed in
    //$this->limit($results, $request->getDisplayStart(), $request->getDisplayLength());
    
   
    // return the final result set
    return new DataTable_DataResult($results, $this->getTotalNumberOfEntities($results), $filteredTotalLength);
		
		
	}
	
	private function getResults(DataTable_Request $request){
		
		$results = array();
		
		$results = $this->getUsers();
	    
	    // search against object array if a search term was passed in
	    if(!is_null($request->getSearch())){
	      //$results = $this->search($request->getSearch(), $this->getSearchableColumnNames());
	    }
	    
	    return $results;
	}
	
	private function search($searchParams, $searchableColumns){
		var_dump($searchableColumns);
		var_dump($searchParams);
		die();
	}
	
	
	private function getUsers(){
		$dat = $this->_db->query('SELECT * FROM users');
		
		$result = array();
		while ($row = $dat->fetch_assoc()){
			$result[] = new User($row['first_name'], $row['last_name'], $row['username']);
		}
		
		
		
		return $result;
	}
	
  private function loadFakeData($file)
  {
    $browsers = array();
    
    if (($handle = fopen($file, "r")) !== FALSE) {
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $browsers[] = new Browser($data[0], $data[1], $data[2], $data[3], $data[4]);
      }
      fclose($handle);
    }

    return $browsers;
  }

	
}