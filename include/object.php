<?php

	class iObject extends PEAR
	{
		function iObject()
		{
			require_once('error.php');
			
			parent::PEAR(IERROR_CLASS);
		}
	
		function isError(&$obj)
		{
			return is_a($obj, 'pear_error');
		}

		function raiseError($message, $code = null, $mode = null, $level = null, $debuginfo = null)
		{
			if (is_object($message) && PEAR::isError($message))
				return parent::raiseError($message->getMessage(), $message->getCode());
			else 
				return parent::raiseError($message, $code, $mode, $level, $debuginfo);
		}

		function getClassVariable($name)
		{
			$vars = get_class_vars(Object::thisClassName());
			if (isset($vars[$name])) return $vars[$name];
			else return null;
		}
		
		function toArray()
		{
			if (!isset($this)) return array();
	    		else return get_object_vars($this);
		}
		
		function reindexArray(&$arr)
		{
			$arr = array_values($arr);
			$newArray = array();
			foreach ($arr as $key => $value)
				$newArray[$key] =& $arr[$key];
			$arr = $newArray;
		}

		function thisClassName()
		{		
			$trace = debug_backtrace();
			return $trace[1]['class'];
		}
		
	}

?>
