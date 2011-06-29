<?php

class EntityGenerator{
	
	protected $_entityString = null;
	
	
	static public function generateEntity($dbTableName, array $dbColumns){
		
		$camelisedDBColumns = self::_cameliseDBColumns($dbColumns);
		
		return self::_getClass($dbTableName, $camelisedDBColumns);
		
	
		
	}
	
	static protected function _getClass($dbTableName, $camelisedDBColumns){
		
		$objectName = self::getEntityObjectName($dbTableName);
		$classParameters = self::getClassParameters($camelisedDBColumns);
		$classMethods = self::getClassMethods($camelisedDBColumns);
		$requiredAbstractMethods = self::_getRequiredAbstractMethods();
		
		$fullClass = htmlspecialchars('<?PHP ');
		$fullClass .= '<br/><br/>';
		$fullClass .=' class '.$objectName.'{';
		$fullClass .= '<br/><br/>';
		$fullClass .= $classParameters;
		$fullClass .= '<br/><br/>';
		$fullClass .= $requiredAbstractMethods;
		$fullClass .= '<br/><br/>';
		$fullClass .= $classMethods;
		$fullClass .= '<br/><br/>';
		$fullClass .= '}';
		$fullClass .= '<br/><br/>';
		$fullClass .= htmlspecialchars('?>');
		return $fullClass;
	}
	
	static protected function _getRequiredAbstractMethods(){
		$methods = '
		
		public function init($mysqlResultRow){
		<br/><br/>
		}
		
		';
		
		return $methods;
	}
	
	static protected function _cameliseDBColumns($dbColumns){
		
		$result = array();
		
		foreach ($dbColumns as $dbColumn){
			$result[$dbColumn] = self::strtocamel($dbColumn);
		}
		
		return $result;
	}
	
	
	static public function getEntityObjectName($dbTableName){
		$camelised = self::strtocamel($dbTableName, true);
		return $camelised.' extends DataTable_DataEntity';
	}

	
	
	static public function getClassParameters(array $camelisedDBColumns){
		
		$string = '';
		foreach ($camelisedDBColumns as $camelisedColumn){
			$string .= 'protected $_'.$camelisedColumn.' = null;';
			$string .= '<br/>';
		}
		
		return $string;
	}
	
	/**
	 * 
	 * Return both a getter and a setter
	 * @param unknown_type $camelisedDBColumns
	 */
	static public function getClassMethods($camelisedDBColumns){
		
		$string = '';
		
		foreach ($camelisedDBColumns as $camelisedColumn){
			$string .= '<br/>';
			$string .= 'public function get'.ucfirst($camelisedColumn).'(){';
			$string .= '<br/>';
			$string .= 'return $this->_'. $camelisedColumn .';';
			$string .= '<br/>';
			$string .= '}';
			$string .= '<br/>';
			$string .= '<br/>';
			$string .= 'public function set'.ucfirst($camelisedColumn).'($value){';
			$string .= '<br/>';
			$string .= '$this->_'. $camelisedColumn .' = $value;';
			$string .= '<br/>';
			$string .= '}';
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