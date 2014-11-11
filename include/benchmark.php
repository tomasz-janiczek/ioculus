<?php

	require_once('Benchmark/Profiler.php');

	class iProfiler extends Benchmark_Profiler
	{
		var $_mode = true;
		var $_root = '';
		var $_name = 'iprofiler';
				
		function & factory($mode = true)
		{
			$obj =& new iProfiler();
			$obj->_mode = $mode;
			return $obj;
		}
				
		function stop()
		{
			parent::stop();

			if (!$this->_mode) return;

			require_once('cache.php');

			$cache =& iCache::singleton();
			if ($cache->isCached($this->_name)) $set =& $cache->get($this->_name);
			else $set = array();

			$set[] =& $this->getAllSectionsInformations();
			
			$cache->save($set, $this->_name);
		}

		function & getStatistics()
		{
			require_once('cache.php');

			$cache =& iCache::singleton();
			if (!$cache->isCached($this->_name)) return false;
			
			$set =& $cache->get($this->_name);
			
			$stats = array();
			foreach ($set as $key => $val) {
				foreach ($set[$key] as $section => $info) {
					if (!isset($stats[$section])) $stats[$section] = array();
					if (!isset($stats[$section]['time'])) $stats[$section]['time'] = 0;
					if (!isset($stats[$section]['rounds'])) $stats[$section]['rounds'] = 0;
					$stats[$section]['time'] += $info['time'];
					$stats[$section]['rounds']++;
				}
			}

			foreach ($stats as $section => $info) {
				$stats[$section]['avg'] = $stats[$section]['time'] / $stats[$section]['rounds'];
			}
			
			return $stats;
		}
	}
			
?>
