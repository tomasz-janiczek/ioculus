<?php

	require_once('object.php');

	define('IMODMAN_DEFAULT_LOAD',		'load');
	define('IMODMAN_DEFAULT_UNLOAD',	'unload');

	class iModuleCommon
	{
		var $root = '';
		var $name = '';
		
		function & factory($name)
		{
			$obj =& new iModuleCommon($name);
			return $obj;
		}
		
		function iModuleCommon($name)
		{
			$this->name = strtolower($name);
		}		
	}

	class iModuleManagerCommon extends iObject
	{
		var $root = '';
		var $modules = array();

		var $_loadMethodName = IMODMAN_DEFAULT_LOAD;
		var $_unloadMethodName = IMODMAN_DEFAULT_UNLOAD;
		
		function & factory($root)
		{
			$obj =& new iModuleManagerCommon($root);
			return $obj;
		}

		function iModuleManagerCommon($root)
		{
			$this->root = $root;
		}

		function & register(&$module)
		{
			if (!is_object($module)) $this->raiseError(null, IERROR_PARAMS);
			
			$module->name = strtolower($module->name);
			$this->modules[$module->name] =& $module;
			
			return $module;
		}

		function unregisterAll()
		{
			unset($this->modules);
			$this->modules = array();
		}
		
		function isLoaded($name)
		{
			if (!is_string($name) || empty($name)) $this->raiseError(null, IERROR_PARAMS);
			
			$name = strtolower($name);
			if (isset($this->modules) && isset($this->modules[$name])) return true;
			else return false;
		}		

		function & get($name)
		{
			if (!is_string($name) || empty($name)) $this->raiseError(null, IERROR_PARAMS);
			
			$name = strtolower($name);
			if (isset($this->modules) && isset($this->modules[$name])) return $this->modules[$name];
			else return $this->raiseError(null, IERROR_NOT_FOUND);
		}		
		
		function loadAll()
		{
			$list =& iFile::getDirectoryList($this->root);
			if ($this->isError($list)) return $list;

			$method = $this->_loadMethodName;
			
			foreach ($list as $dirName) {
				$module =& $this->$method($dirName);
				if ($this->isError($module)) return $module;
				$result = $this->register($module);
				if ($this->isError($result)) return $result;
			}

			return true;
		}
		
		function & load($name)
		{
			return $this->raiseError(null, IERROR_UNSUPPORTED);
		}
		
		function unload($name)
		{
			return $this->raiseError(null, IERROR_UNSUPPORTED);
		}		
	}

?>
