<?php

	require_once('LiveUser/Admin.php');
	
	class iUserAdmin extends LiveUser_Admin
	{
		function & factory(&$conf)
		{
			$debug = false;
		        if (array_key_exists('debug', $conf)) {
		        	$debug =& $conf['debug'];
			}

			$obj = &new iUser_Admin($debug);

			if (is_array($conf)) {
				$obj->_conf = $conf;
			}

		        return $obj;
		}
		
		function countResults($table, $where = array())
		{
			$query = 'SELECT count(*) AS count FROM ' . 
				       $this->perm->_storage->prefix . $this->perm->_storage->alias[$table];
			if (!empty($where)) {
				$query .= ' WHERE ';
				$first = true;
				foreach ($where as $key => $value) {
					if ($first === true) $first = false;
					else $query .= ' AND ' ;
					$query .= $key . '=' . "'" . $value . "'";
				}
			}
			$result = $this->perm->_storage->dbc->queryRow($query, array('integer'), MDB2_FETCHMODE_ASSOC);
			if ($result === false) return false;
			return $result['count'];
		}
	}

?>