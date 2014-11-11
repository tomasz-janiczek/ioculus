<?php

	require_once('MDB/QueryTool.php');

	class iModule_DB extends MDB_QueryTool
	{
		var $_core = null;
		var $_filter = true;

		function & getCore()
		{
			return $this->_core;
		}

		function filtersEnabled()
		{	
			if (!empty($this->_core)) $a = $this->_core->_filterQueries;
			else $a = true;
			
			$b = $this->_filter;
			
			if ($a && $b) {
				return true;
			} else {
				return false;
			}
		}

		function enableFilters()
		{
			$this->_filter = true;
		}

		function disableFilters()
		{
			$this->_filter = false;
		}

		function filterQuery()
		{
		}
		
		function & getAll($from = 0, $count = 0)
		{
			if ($this->filtersEnabled()) $this->filterQuery();			
			return parent::getAll($from, $count);
		}
		
		function & getMultiple($ids, $column = '')
		{
			if ($this->filtersEnabled()) $this->filterQuery();			
			return parent::getMultiple($ids, $column);
		}

		function & getCol($column = null, $from = 0, $count = 0)
		{
			if ($this->filtersEnabled()) $this->filterQuery();			
			return parent::getCol($column, $from, $count);
		}

		function & get($id, $column = '')
		{
			if ($this->filtersEnabled()) $this->filterQuery();			
			return parent::get($id, $column);
		}
	}
?>
