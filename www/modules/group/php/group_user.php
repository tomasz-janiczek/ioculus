<?php

	class iModule_Group_User extends iModuleDB
	{
		var $_dbTable = 'liveuser_groupusers';

		function & onGetUserGroups(&$core, &$args)
		{
			$params = array(
				'filters' => array('perm_user_id' => $args['id']),
				'fields' => array('group_id')
			);
			$result =& $core->userAdmin->perm->getGroups($params);
			if (!$result) return $this->raiseError($core->userAdmin->getErrors());
			
			$groups = array();
			foreach ($result as $val) $groups[] = $val['group_id'];
			unset($result);
			
			return $groups;
		}
		
		function & onList(&$core, &$args)
    		{
	    		$params = array();
			if (!empty($args['filters'])) $params['filters'] =& $args['filters'];

			$result =& $core->userAdmin->getUsers($params);
			if ($result === false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			$options = array();
			foreach ($result as $value) {
				$id = $value['perm_user_id'];
				$name = $value['handle'];
				$options[$id] = $name;
			}
			unset($result);
			
			return $options;
		}

		function & onAddForm(&$core, &$args)
		{
			$groups =&  $this->call($this->name, 'list', array('return' => 'options'));
			if ($this->isError($groups)) return $groups;

			$users =&  $this->onList($core, $args);
			if ($this->isError($users)) return $users;
			
			$core->smarty->assign('action', iCore::URL($this->name, 'addgroupuser'));
			$core->smarty->assign('gid', $args['gid']);
			$core->smarty->assign_by_ref('groups', $groups);
			$core->smarty->assign_by_ref('users', $users);
			
			return true;
		}

		function & onAdd(&$core, &$args)
		{
			$result = $core->userAdmin->perm->addUserToGroup(array('perm_user_id' => $args['id'], 'group_id' => $args['gid']));
			if ($result === false) return $this->raiseError(null, IERROR_DB_INSERT);
			
			return true;
		}

		function & onDeleteSingle(&$core, &$args)
		{
			$result = $core->userAdmin->perm->removeUserFromGroup(array('perm_user_id' => $args['id'], 'group_id' => $args['gid']));
			if ($result === false) return $this->raiseError(null, IERROR_DB_REMOVE);
			
			return true;
		}
	}

?>
