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
		
		
		
		   // get fake data set
   // $results = $this->loadFakeData('browsers.csv');

	$results = $this->getUsers();
    
    // search against object array if a search term was passed in
    if(!is_null($request->getSearch())){
      //$results = $this->search($results, $request->getSearch(), $this->getSearchableColumnNames());
    }

    // get the count of the filtered results
    $filteredTotalLength = count($results);
    
    // sort results by sort column passed in
    //$this->sortObjectArray($this->config->getColumns()->get($request->getSortColumnIndex())->getSortKey(), $results, $request->getSortDirection());

    // limit the results based on parameters passed in
    //$this->limit($results, $request->getDisplayStart(), $request->getDisplayLength());
    
   
    // return the final result set
    return new DataTable_DataResult($results, $this->getTotalNumberOfEntities($results), $filteredTotalLength);
		
		
	}
	

	private function getUsers(){
		$dat = $this->_db->query('SELECT * FROM users');
		
		$result = array();
		while ($row = $dat->fetch_assoc()){
			$result[] = new 
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