<?php

	class iModule_Profile extends iModule
	{
		var $_dbTable = 'profile';
		var $options = array('serialize' => true);
		
		function & onAdd(&$core, &$args)
		{
			$this->db->reset();
			$result =& $this->db->add(array('user_id' => $args['id'], 'pref_id' => $args['name'], 'pref_value' => serialize($args['value'])));
			if ($result === false) return $this->raiseError(null, IERROR_DB_INSERT);
				
			return $result;
		}

		function & onAddMultiple(&$core, &$args)
		{
			$this->db->reset();
			
			$set = array();
			foreach ($args['prefs'] as $key => $value) 
				$set[] = array('user_id' => $args['id'], 'pref_id' => $key, 'pref_value' => serialize($value));
				
			$result =& $this->db->addMultiple($set);
			if ($result === false) return $this->raiseError(null, IERROR_DB_INSERT);
				
			return $result;
		}

		function & onEdit(&$core, &$args)
		{
			$this->db->reset();

			$result =& $this->db->update(array('user_id' => $args['id'], 'pref_id' => $args['name'], 'pref_value' => serialize($args['value'])));
			if ($result === false) return $this->raiseError(null, IERROR_DB_UPDATE);
				
			return true;
		}

		function & onEditMultiple(&$core, &$args)
		{
			$this->db->reset();

			$query = "INSERT INTO profile (user_id,pref_id,pref_value) VALUES ";
			$values = '';

			foreach ($args['prefs'] as $key => $value) {
				$value = serialize($value);
				if (!empty($values)) $values .= ',';
				$values .= "('{$args['id']}','{$key}','{$value}')";
			}
	
			$query .= $values . " ON DUPLICATE KEY UPDATE pref_value=VALUES(pref_value)";

			$result =& $this->db->execute($query);
			if ($result === false) return $this->raiseError(null, IERROR_DB_UPDATE);
				
			return true;
		}

		function & onDelete(&$core, &$args)
		{
			$this->db->reset();
			$result =& $this->db->remove(array('user_id' => $args['id'], 'pref_id' => $args['name']));
			if ($result === false) return $this->raiseError(null, IERROR_DB_DELETE);
							
			return true;
		}

		function & onDeleteAll(&$core, &$args)
		{
			$this->db->reset();
			$this->db->remove($args['id'], 'user_id');

			return true;
		}

		function & onGet(&$core, &$args)
		{			
			$this->db->reset();
			$this->db->setSelect('pref_value AS value');
			$this->db->setWhere("user_id = '{$args['id']}'");
			$this->db->addWhere("pref_id = '{$args['name']}'");
			
			$result =& $this->db->getAll();
			if ($result === false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			return unserialize($result[0]['value']);
		}

		function & onGetAll(&$core, &$args)
		{
			$this->db->reset();
			$this->db->setSelect('pref_id, pref_value');
			$this->db->setWhere("user_id = '{$args['id']}'");
			$this->db->setOrder('pref_id', true);
			
			$result =& $this->db->getAll();
			if ($result === false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			$prefs = array();
			foreach ($result as $value) {
				if ($this->options['serialize'])
					$prefs[$value['pref_id']] = unserialize($value['pref_value']);
				else
					$prefs[$value['pref_id']] = $value['pref_value'];
			}
			unset($result);
			
			return $prefs;
		}
	} 

?>
