<?php
include('User.php');
class DbTestDataTable extends DataTable_DataTable{
	


	public function __construct(DataTable_Config $config = null) {
		
	$column1 = new DataTable_Column();
    $column1->setName("username")
            ->setTitle("Username")
            ->setGetMethod("getUsername")
            ->setSortKey("username")
            ->setIsSortable(true)
            ->setIsSearchable(true)
            ->setIsDefaultSort(true);
         
    $column2 = new DataTable_Column();
    $column2->setName("first_name")
            ->setTitle("First Name")
            ->setGetMethod("getFirstName")
            ->setSortKey("first_name")
            ->setIsSortable(true)
            ->setIsDefaultSort(false);
    
    $column3 = new DataTable_Column();
    $column3->setName("last_name")
            ->setTitle("Last Name")
            ->setGetMethod("getLastName")
            ->setSortKey("last_name")
            ->setIsSortable(true)
            ->setIsSearchable(true)
            ->setIsDefaultSort(false);
	
    
    // create config
    $config = new DataTable_Config();
    

    
    
    // add columns to collection
    $config->getColumns()->add($column1)
    					 ->add($column2)
    					 ->add($column3);
     
    // build the language configuration
    $languageConfig = new DataTable_LanguageConfig();
    $languageConfig->setPaginateFirst("Beginning")
                   ->setPaginateLast("End")
                   ->setSearch("Find it:");

    // add LangugateConfig to the DataTableConfig object
    $config->setLanguageConfig($languageConfig);

    // set data table options
    $config->setClass("display")
           ->setDisplayLength(10)
           ->setIsPaginationEnabled(true)
           ->setIsLengthChangeEnabled(true)
           ->setIsFilterEnabled(true)
           ->setIsInfoEnabled(true)
           ->setIsSortEnabled(true)
           ->setIsAutoWidthEnabled(true)
           ->setIsScrollCollapseEnabled(false)
           ->setPaginationType(DataTable_Config::PAGINATION_TYPE_FULL_NUMBERS)
           ->setIsJQueryUIEnabled(false)
           ->setIsServerSideEnabled(true);
         
    //create the data source
    $dataSource = new DataTable_DataSourceMysqli($config, new mysqli('localhost', 'root', 'root', 'php-datatables'));
    $config->setDataSource($dataSource);
    
     parent::__construct($config);
		
	}

	public function getTableId() {
		return 'testing';
		
	}
	
	  protected function getRowCallbackFunction()
	  {
	  	return true;
	  	
	    return "
	            function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
	
	    			/* Bold the grade for all 'A' grade browsers */
	    			if ( aData[{$this->getColumnIndexByName('cssGrade')}] == 'A' )
	    			{
	    				$('td:eq({$this->getColumnIndexByName('cssGrade')})', nRow).html( '<b>A</b>' );
	    			}
	    			return nRow;
	            }
	    ";
	  }


	protected function getActions(Browser $browser)
	  {
	    $html = "<a href=\"#\" onclick=\"alert('Viewing: {$browser->getBrowser()}');\">View</a>";
	    $html .= ' | ';
	    $html .= "<a href=\"#\" onclick=\"confirm('Delete {$browser->getBrowser()}?');\">Delete</a>";
	    return $html;
	  }
  
	  /**
	   * Format the data for the 'invisible' column
	   * 
	   * @param Browser $browser
	   */
	  protected function getInvisible(Browser $browser)
	  {
	    return 'invisible content: ' . $browser->getBrowser();
	  }
}