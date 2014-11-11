<?php
	
	class iModule_Right_User extends iModuleDB
	{
		var $_dbTable = 'liveuser_userrights';
		
		function & onListUser(&$core, &$args)
		{
			$users =& $core->call('user', 'listasoptions');
			if ($this->isError($users)) return $this->raiseError($users);
			
			$core->smarty->assign('action', iCore::URL($this->name, 'listuser'));
			$core->smarty->assign_by_ref('users', $users);
			
			return true;
		}

		function & onListUserForm(&$core, &$args)
	    	{
	    		$user =& $core->call('user', 'exists', array('id' => $args['uid'], 'all' => true));
	    		if ($user === false) return $this->raiseError('Użytkownik o id=' . $args['uid'] . ' nie istnieje');
	    			    	
			$this->paginate->setTotal($this->onCount($core, array('filters' => "perm_user_id = {$args['uid']}")));

			$params = array(
				'fields' => array('right_id', 'right_define_name', 'right_description'),
				'filters' => array('perm_user_id' => $args['uid']),
			);
			$rights =& $core->userAdmin->perm->getRights($params);
			if ($rights === false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			$core->smarty->assign_by_ref('user', $user);
			$core->smarty->assign_by_ref('rights', $rights);
			
			return true;
		}

		function & onGetUserRights(&$core, &$args)
		{
			$params = array(
				'fields' => array('right_id', 'right_define_name', 'right_description', 'area_id', 'area_define_name'),
				'filters' => array('perm_user_id' => $args['id']),
				'selectable_tables' => array('userrights', 'rights', 'areas', 'translations'),
				'by_group' => true,
			);
			$rights =& $core->userAdmin->perm->getRights($params);
			if ($rights === false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			return $rights;
		}

		function & onAddForm(&$core, &$args)
		{
			$user =& $core->call('user', 'exists', array('id' => $args['id'], 'all' => true));
			if ($this->isError($user)) return $user;

			$areas =& $this->call('area', 'list');
			if ($this->isError($areas)) return $areas;

			reset($areas);
			$args['area_id'] = key($areas);
			
			$rights =& $this->call($this->name, 'list', array('return' => 'raw', 'id' => $args['area_id']));
			if ($this->isError($rights)) return $rights;
			
			$userRights =& $this->onGetUserRights($core, $args);
			if ($this->isError($userRights)) return $userRights;
			
			$userRightIds = array();
			foreach ($userRights as $val) {
				if ($val['area_id'] == $args['area_id'] && $val['right_define_name'] == '*') {
					var_dump::display($val);
					var_dump::display($args);
					$rights = array();
					break;
				}
				$userRightIds[] = $val['right_id'];
			}
			
			if (!empty($rights)) {
				foreach ($rights as $key => $val) if (in_array($val['right_id'], $userRightIds)) unset($rights[$key]);
				$rights = array_values($rights);
			}
			
			$core->smarty->assign_by_ref('areas', $areas);
			$core->smarty->assign_by_ref('rights', $rights);
			$core->smarty->assign_by_ref('group_rights', $userRights);
			$core->smarty->assign_by_ref('user', $user);
			
			return true;
		}

	    	function & onAdd(&$core, &$args)
    		{
			$params = array('perm_user_id' => $args['id'], 'right_id' => $args['rid'], 'right_level' => 3);
			$granted =& $core->userAdmin->perm->grantUserRight($params);
			if ($granted === false) return $this->raiseError(null, IERROR_DB_INSERT);
			
			return true;
		}
		
    		function & onDeleteSingle(&$core, &$args)
	    	{
			$result = $core->userAdmin->perm->revokeUserRight(array('perm_user_id' => $args['id'], 'right_id' => $args['rid']));
			if ($result === false) return $this->raiseError(null, IERROR_DB_REMOVE);
			
			return true;
		}
	}

?>
