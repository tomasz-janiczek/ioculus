<?php

	require_once('object.php');

	class iDispatcher extends iObject
	{
		var $prefix = 'xml_';

		function & singleton()
		{
			static $instance = null;
			
			if (!$instance) $instance =& iDispatcher::factory();

			return $instance;
		}

		function & factory()
		{
			$obj =& new iDispatcher();
			return $obj;
		}
		
		function post(&$params)
		{
			if (!is_array($params)) return $this->raiseError(null, IERROR_PARAMS);
			
			if (!isset($this->handlers)) {
				$methods = get_class_methods(get_class($this));
				$this->handlers = array();
				
			    	foreach ($methods as $name) {
			    		if (!strncasecmp($name, $this->prefix, strlen($this->prefix))) $this->handlers[] = $name;
			    	}
			}
		    
		    	foreach ($this->handlers as $method) {
				$result =& call_user_func_array(array(&$this, $method), $params);
	    			if ($this->isError($result)) return $result;
		    	}			
			
			return true;
		}		

		function & postSingle($name, &$params)
		{
			if (!is_string($name) || empty($name) || !is_array($params)) return $this->raiseError(null, IERROR_PARAMS);
			
			$method = $this->prefix . $name;
			
			if (method_exists($this, $method)) return call_user_func_array(array(&$this, $method), $params);
			else return $this->raiseError(null, IERROR_UNSUPPORTED);
		}		
	}

?>