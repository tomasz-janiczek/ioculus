<?php

	require_once('object.php');

	class iActionParam extends iObject
	{
		var $type = IPARAM_GETPOST;
		var $name = '';
		var $required = true;
		
		// For IPARAM_FILE parameters
		var $minSize = 0;
		var $maxSize = 0;
		var $requiredSize = 0;
		var $mimeTypes = array();
		var $extensions = array();

		function & factory($name, $required = true)
		{
			$obj =& new iActionParam($name);
			if (is_bool($required)) $obj->required = $required;
			return $obj;
		}
		
		function iActionParam($name)
		{
			parent::iObject();
			$this->name = $name;
		}
		
		function runModifier($name, &$param)
		{
			require_once('modifiers.php');

			$obj =& iParamModifier::singleton();
			return $obj->postSingle($name, $param);
		}
		
		function & runModifiers(&$param)
		{
			if (!isset($this->modifiers) || empty($this->modifiers)) return true;
			
			require_once('modifiers.php');
			
			$obj =& iParamModifier::singleton();
			
			foreach ($this->modifiers as $name => $args) {
				$result =& $obj->postSingle($name, $tmp = array(array('value' => &$param, 'params' => &$args)));
				if ($this->isError($result)) return array('name' => $name, 'params' => $args, 'error' => $result);
			}

			return true;
		}

		function & runValidators(&$param)
		{
			if (!isset($this->validators) || empty($this->validators)) return true;
			
			require_once('validators.php');
			
			$obj =& iParamValidator::singleton();
			
			foreach ($this->validators as $name => $args) {
				$result =& $obj->postSingle($name, $tmp = array(array('value' => $param, 'params' => $args)));
				if ($this->isError($result)) return array('name' => $name, 'params' => $args, 'error' => $result);
			}

			return true;
		}
		
		function & getValidator($name)
		{
			if (!is_string($name) || empty($name)) return $this->raiserError(null, IERROR_PARAMS);
			
			$name = strtolower($name);
			if (isset($this->validators) && isset($this->validators[$name])) return $this->validators[$name];
			else return $this->raiseError(null, IERROR_NOT_FOUND);
		}

		function & getModifier($name)
		{
			if (!is_string($name) || empty($name)) return $this->raiserError(null, IERROR_PARAMS);
			
			$name = strtolower($name);
			if (isset($this->modifiers) && isset($this->modifiers[$name])) return $this->modifiers[$name];
			else return $this->raiseError(null, IERROR_NOT_FOUND);
		}
		
		function registerValidator($name, $params = array())
		{
			if (!is_string($name) || empty($name) || !is_array($params)) return $this->raiserError(null, IERROR_PARAMS);
	
			if (!isset($this->validators)) $this->validators = array();
			$this->validators[strtolower($name)] = $params;

			return true;
		}

		function registerModifier($name, $params = array())
		{
			if (!is_string($name) || empty($name) || !is_array($params)) return $this->raiserError(null, IERROR_PARAMS);

			if (!isset($this->modifiers)) $this->modifiers = array();
			$this->modifiers[strtolower($name)] = $params;	

			return true;
		}
	}

?>
