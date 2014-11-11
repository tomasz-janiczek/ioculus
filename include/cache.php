<?php

	require_once('Cache/Lite.php');

	class iCache extends Cache_Lite
	{
		function & singleton()
		{
			static $instance = null;
			
			if (!$instance) $instance =& iCache::factory();
			return $instance;
		}

		function & factory($cacheDir = null)
		{
			global $config;
			
			if (!$cacheDir) $cacheDir = $config['dir']['cache'];
			if (substr($cacheDir, -1, 1) != '/') $cacheDir .= DIRECTORY_SEPARATOR;
		
			$options = array(
				'caching' => true,
				'cacheDir' => $cacheDir,
				'lifeTime' => null,
				'automaticSerialization' => true,
				'fileLocking' => true,
				'readControl' => false,
				'writeControl' => false,
				'fileNameProtection' => false
			);

			$obj =& new iCache($options);
			return $obj;
		}

		function isCached($id, $group = 'default')
		{
        	$this->_id = $id;
	        $this->_group = $group;

   	        $this->_setFileName($id, $group);

			clearstatcache();
			return file_exists($this->_file);
	    } 
	}

?>
