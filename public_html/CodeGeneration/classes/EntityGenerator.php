<?php

class EntityGenerator{
	
	protected $_entityString = null;
	
	
	static public function generateEntity($dbTableName, array $dbColumns){
		$objectName = self::getEntityObjectName($dbTableName);
		
		
	}
	
	
	static public function getEntityObjectName($dbTableName){
		$camelised = self::strtocamel($dbTableName);
		
		return $camelised.' extends DataTable_DataEntity';
	}
	
		
	static public function camelize($string, $pascalCase = false)
	{
	  $string = str_replace(array('-', '_'), ' ', $string);
	  $string = ucwords($string);
	  $string = str_replace(' ', '', $string); 
	
	  if (!$pascalCase) {
	    return lcfirst($string);
	  }
	  return $string;
	} 
	
	
	static public function strtocamel($str, $capitalizeFirst = false, $allowed = 'A-Za-z0-9') {
    return preg_replace(
        array(
            '/([A-Z][a-z])/e', // all occurances of caps followed by lowers
            '/([a-zA-Z])([a-zA-Z]*)/e', // all occurances of words w/ first char captured separately
            '/[^'.$allowed.']+/e', // all non allowed chars (non alpha numerics, by default)
            '/^([a-zA-Z])/e' // first alpha char
        ),
        array(
            '" ".$1', // add spaces
            'strtoupper("$1").strtolower("$2")', // capitalize first, lower the rest
            '', // delete undesired chars
            'strto'.($capitalizeFirst ? 'upper' : 'lower').'("$1")' // force first char to upper or lower
        ),
        $str
    );
	}
	
}