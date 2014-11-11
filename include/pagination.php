<?php

	class iPagination
	{
		var $id = '';
		var $url = '';
		var $total = 0;
		var $limit = 25;
		var $urlVar = 'page';
		var $varName = 'paginate';

		function & factory()
		{
			$obj =& new iPagination();
			return $obj;
		}

		function setId($value)
		{
			$this->id = $value;
		}

		function setLimit($value)
		{
			$this->limit = $value;
		}

		function setTotal($value)
		{
			$this->total = $value;
		}

		function setURL($value)
		{
			$url = array();
			parse_str($value, $url);
			
			if (isset($url[$this->urlVar])) {
				unset($url[$this->urlVar]);

				require_once('PHP/Compat.php');
				PHP_Compat::loadFunction('http_build_query');

				$value = http_build_query($url);
			}

			$this->url = strstr($value, '?') ? $value : ('?' . $value);
		}

		function setUrlVariable($value)
		{
			$this->urlVar = $value;
		}

		function getURL()
		{
			require_once('smarty/SmartyPaginate.class.php');
			
			return SmartyPaginate::getURL($this->id);
		}

		function getLimit()
		{
			require_once('smarty/SmartyPaginate.class.php');
			
			return SmartyPaginate::getLimit($this->id);
		}

		function getIndex()
		{
			require_once('smarty/SmartyPaginate.class.php');
			
			return SmartyPaginate::getCurrentIndex($this->id);
		}

		function connect()
		{
			require_once('smarty/SmartyPaginate.class.php');
				
			SmartyPaginate::connect($this->id);
			SmartyPaginate::setLimit($this->limit, $this->id);
		}
		
		function assign(&$smarty)
		{
			require_once('smarty/SmartyPaginate.class.php');
			
			SmartyPaginate::setUrlVar($this->urlVar, $this->id);
			SmartyPaginate::setUrl($this->url, $this->id);
			SmartyPaginate::setLimit($this->limit, $this->id);
			SmartyPaginate::setTotal($this->total, $this->id);
			
			SmartyPaginate::assign($smarty, $this->varName, $this->id);
			
			$smarty->assign('paginate_id', $this->id);
		}
	}
	
?>
