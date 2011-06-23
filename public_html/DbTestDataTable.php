<?php
include('Browser.php');
class DbTestDataTable extends DataTable_DataTable{
	


	public function __construct(DataTable_Config $config = null) {
		
		
		// create first column
    $column1 = new DataTable_Column();
    $column1->setName("renderingEngine")
            ->setTitle("Rendering Engine")
            ->setGetMethod("getRenderingEngine")
            ->setSortKey("renderingEngine")
            ->setIsSortable(true)
            ->setIsDefaultSort(true);

    // create second column
    $column2 = new DataTable_Column();
    $column2->setName("browser")
            ->setTitle("Browser")
            ->setGetMethod("getBrowser")
            ->setSortKey("browser")
            ->setIsSortable(true)
            ->setIsSearchable(true);

    // create third column
    $column3 = new DataTable_Column();
    $column3->setName("platform")
            ->setTitle("Platform(s)")
            ->setGetMethod("getPlatform")
            ->setSortKey("platform")
            ->setIsSortable(true)
            ->setIsDefaultSort(false);

    // create fourth column
    $column4 = new DataTable_Column();
    $column4->setName("engineVersion")
            ->setTitle("Engine Version")
            ->setGetMethod("getEngineVersion")
            ->setSortKey("engineVersion")
            ->setIsSortable(true)
            ->setIsDefaultSort(false);
    
    // create fifth column
    $column5 = new DataTable_Column();
    $column5->setName("cssGrade")
            ->setTitle("CSS Grade")
            ->setGetMethod("getCssGrade")
            ->setSortKey("cssGrade")
            ->setIsSortable(true)
            ->setIsDefaultSort(false);

    // create the actions column
    $column6 = new DataTable_Column();
    $column6->setName("actions")
            ->setTitle("Actions")
            ->setGetMethod("getActions"); //calls the getActions() method in this class
    
    // create an invisible column
    $column7 = new DataTable_Column();
    $column7->setName("invisible")
            ->setTitle("Invisible")
            ->setIsVisible(false)
            ->setGetMethod("getInvisible");
    
    // create config
    $config = new DataTable_Config();
    
    $dataSource = new DataTable_DataSourceMysqli(new mysqli('localhost', 'root', 'root', 'php-datatables'));
 
    
    $config->setDataSource($dataSource);
    
    
    // add columns to collection
    $config->getColumns()->add($column1)
                         ->add($column2)
                         ->add($column3)
                         ->add($column4)
                         ->add($column5)
                         ->add($column6)
                         ->add($column7);
     
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
         

    
     parent::__construct($config);
		
	}

	public function getTableId() {
		return 'testing';
		
	}
	
	  protected function getRowCallbackFunction()
	  {
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