<?php

	require_once('LiveUser.php');

	class iUser extends LiveUser
	{
		var $_rightList = array();
		
		function _freeze()
		{
			parent::_freeze();
			$_SESSION[$this->_options['session']['varname']]['_rightList'] = $this->_rightList;
		}

		function _unfreeze()
		{
			if (isset($_SESSION[$this->_options['session']['varname']]))
				$this->_rightList = $_SESSION[$this->_options['session']['varname']]['_rightList'];
			parent::_unfreeze();
		}
				
		function & getRightNamesList()
		{
			return $this->_rightList;
		}
		
		function & factory($conf)
		{
			$debug = false;
			if (array_key_exists('debug', $conf)) {
				$debug =& $conf['debug'];
			}

			$obj =& new iUser($debug);

			if (is_array($conf)) {
				$obj->readConfig($conf);
			}

			return $obj;
		}
	}

?>
