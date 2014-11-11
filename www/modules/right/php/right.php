<?php
	
	class iModule_Right extends iModuleDB
	{
		var $_dbTable = 'liveuser_rights';
		
	    	function & _onLoad(&$core, &$args)
	    	{
	    		$core->addObserver('core', 'moduleLoaded', array($this->name, 'rescan'));
	    		
	    		$cachedMods =& $core->moduleManager->getCachedModules();
	    		foreach ($cachedMods as $modname) {
	    			if ($modname == $this->name) continue;
	    			
				$module =& $core->moduleManager->getModule($modname);
				if ($this->isError($module)) return $this->raiseError($module);

				$result = $this->addDefaultModuleRights($module);
				if ($this->isError($result)) return $this->raiseError($result);
	    		}
	    		
	    		return true;
		} 

		function & getApplicationId()
		{
			if (!isset($this->appId)) {
				$core =& $this->_core;
				$core->userAdminConnect();
			
		    		$result =& $core->userAdmin->perm->getApplications(array('filters' => array('application_define_name' => 'ioculus')));
    				if ($result === false) return $this->raiseError($core->userAdmin->getErrors());
	    		
		    		$this->appId = $result[0]['application_id'];
    				unset($result);
			}
			
			return $this->appId;
		}

		function addDefaultModuleRights(&$module)
		{
			$core =& $this->getCore();

	    		// Connect the userAdmin object. All speciall actions (onLoad, onExecute), in contrary to the standard ones, do not automatically connect to the
	    		// databases - you must do it manually.
	    		$core->userAdminConnect();
						
			$core->log("Checking if area {$module->name} exists");
			$area =& $this->call('area', 'exists', array('id' => $module->name, 'all' => true));
    			if ($area == false) {
				$areaId = $this->call('area', 'add', array('name' => $module->name, 'description' => $module->description));
				if ($this->isError($areaId)) return $areaId;
			} else $areaId = $area['area_id'];
			
			$core->log("Checking if general right {$module->name}::* exists");
			$right = $this->onExists($core, $args = array('areaid' => $areaId, 'id' => '*'));
			if ($right == false) {
				$right = $this->onAdd($core, $args = array('areaid' => $areaId, 'name' => '*', 'description' => 'Full access to module ' . $module->name));
				if ($this->isError($right)) return $right;
			}

			$actions =& $module->getActionList();
			foreach ($actions as $key => $value) {
				$core->log("Checking if right {$areaId}::{$value} exists");
				$right = $this->onExists($core, $args = array('areaid' => $areaId, 'id' => $value));
				if ($right != false) continue;

				$right = $this->onAdd($core, $args = array('areaid' => $areaId, 'name' => $value, 'description' => 'Access to action ' . $module->name . '::' . $value));
				if ($this->isError($right)) return $right;
			}
			
			return true;
		}

		// RIGHTS

		function & getUserRights($id)
		{
			$core =& $this->getCore();
			
			$params = array(
				'fields' => array('right_id', 'right_define_name', 'right_description', 'area_id', 'area_define_name'),
				'filters' => array('perm_user_id' => $id),
				'selectable_tables' => array('userrights', 'groups', 'grouprights', 'rights', 'groupusers', 'areas', 'translations'),
				'by_group' => true,
			);
			$rights =& $core->userAdmin->perm->getRights($params);
			if ($rights === false) return $this->raiseError($core->userAdmin->getErrors());
			else return $rights;
		}
			    
		function & onListForm(&$core, &$args)
		{
			$this->paginate->setTotal($this->onCount($core, $args));
			
			$filters = array(
				'offset' => $this->paginate->getIndex(),
				'limit' => $this->paginate->getLimit(),
				'orders' => array('area_define_name' => 'ASC'),
				'fields' => array('right_id', 'right_define_name', 'right_description', 'area_id'),
				'with' => array('area_id' => '')
			);
			$rights =& $core->userAdmin->perm->getRights($filters);
			if ($rights === false) return $this->raiseError(null, IERROR_DB_QUERY);

			$core->smarty->assign_by_ref('rights', $rights);
			
			return true;
		}

    		function & onAddForm(&$core, &$args)
    		{
			$areas =& $this->call('area', 'list', array('return' => 'options'));
	    		if ($this->isError($areas)) return $this->raiseError($areas);

			$core->smarty->assign('action', iCore::URL($this->name, 'add'));
			$core->smarty->assign_by_ref('areas', $areas);
			
			return true;
    		}

    		function & onEditForm(&$core, &$args)
    		{
			$right =& $this->onExists($core, $params = array('id' => $args['id'], 'all' => true));
	    		if (!$right) return $this->raiseError(null, IERROR_NOT_FOUND);

			$areas =& $this->call('area', 'list', array('return' => 'options'));
	    		if ($this->isError($areas)) return $this->raiseError($areas);

			$core->smarty->assign('action', iCore::URL($this->name, 'edit', array('id' => $args['id'])));
			$core->smarty->assign('selected', $right['area_id']);
			$core->smarty->assign_by_ref('areas', $areas);
			$core->smarty->assign_by_ref('right', $right);
			
			return true;
  	  	}

		function & onExists(&$core, &$args)
		{
			$params = array('filters' => array());

			if (is_numeric($args['id']))
				$params['filters']['right_id'] = $args['id'];
			else if (is_string($args['id']) && !empty($args['areaid'])) {
				$params['filters']['right_define_name'] = $args['id'];

				$area =& $this->call('area', 'exists', array('id' => $args['areaid'], 'all' => true));
				if (!$area) return false;
			
				$params['filters']['area_id'] = $area['area_id'];
			} else return false;
			
			$right =& $core->userAdmin->perm->getRights($params);
			if ($right === false) return false;
			
			if (!empty($args['all']) && $args['all']) return $right[0];
			else return $right[0]['right_define_name'];
		}

		function & onList(&$core, &$args)
    		{
			if (empty($args['return'])) $args['return'] = 'fullname_options';

			$params = array(
				'fields' => array('right_id', 'right_define_name', 'right_description', 'area_id'),
				'with' => array('area_id' => ''),
				'order' => array('right_define_name')
			);
			if (!empty($args['id'])) {
				if (is_numeric($args['id']))
					$params = array('filters' => array('area_id' => $args['id']));
				else 
					$params = array('filters' => array('area_define_name' => strtolower($args['id'])));
				$areaInfo =& $core->userAdmin->perm->getAreas($params);
				if ($areaInfo === false) return $this->raiseError(null, IERROR_DB_QUERY);
				$params['filters']['area_id'] = $areaInfo[0]['area_id'];
			}

			$result =& $core->userAdmin->perm->getRights($params);
			if ($result === false) return $this->raiseError(null, IERROR_DB_QUERY);

			$rights = array();
			
			switch ($args['return']) {
			case 'fullname_options':
			default:
				foreach ($result as $value) {
					$id = $value['right_id'];
					$name = $value['areas'][0]['area_define_name'] . '::' . $value['right_define_name'];
					$rights[$id] = $name;
				}
				break;

			case 'options':
				foreach ($result as $value) {
					$id = $value['right_id'];
					$name = $value['right_define_name'];
					$rights[$id] = $name;
				}
				break;

			case 'raw':
				$rights = $result;
				break;
			}
			
			unset($result);
			
			return $rights;
		}

		function & onAdd(&$core, &$args)
    		{
			$area =& $this->call('area', 'exists', array('id' => $args['areaid'] , 'all' => true));
	    		if (!$area) return $this->raiseError(null, IERROR_NOT_FOUND);

			$right = array(
				'area_id' => $area['area_id'],
				'right_define_name' => $args['name'],
				'right_description' => $args['description']
			);
			$right =& $core->userAdmin->perm->addRight($right);
			if ($right === false) return $this->raiseError(null, IERROR_DB_INSERT);
			
			return true;
		}

		function & onEdit(&$core, &$args)
		{
			$area =& $this->call('area', 'exists', array('id' => $args['areaid'] , 'all' => true));
	    		if (!$area) return $this->raiseError(null, IERROR_NOT_FOUND);

			$data = array(
				'area_id' => $area['area_id'],
				'right_define_name' => $args['name'],
				'right_description' => $args['description']
			);
			$result =& $core->userAdmin->perm->updateRight($data, array('right_id' => $args['id']));
			if ($result === false) return $this->raiseError(null, IERROR_DB_UPDATE);
			
			return true;
		}

		function & onDeleteSingle(&$core, &$args)
		{
			$result =& $core->userAdmin->perm->removeRight(array('right_id' => $args['id']));
			if ($result === false) return $this->raiseError(null, IERROR_DB_REMOVE);
			
			return true;
		}

	    	function & onRescan(&$core, &$args)
	    	{
		    	$core->log('Event moduleLoaded. Module name: ' . $args['module']);
    	
			$module =& $core->moduleManager->getModule($args['module']);
			if ($this->isError($module)) return $module;
			
	    		return $this->addDefaultModuleRights($module);
		}

		// AREAS

		function & onAreaExists(&$core, &$args)
		{
			return $this->call('area', 'exists', array('id' => $aid, 'all' => isset($args['all']) ? $args['all'] : false));
		}

		function & onListAreaForm(&$core, &$args)
		{
			return $this->call('area', 'listform', $args);
		}

		function & onAddAreaForm(&$core, &$args)
		{
			return $this->call('area', 'addform', $args);
		}

		function & onEditAreaForm(&$core, &$args)
		{
			return $this->call('area', 'editform', $args);
		}

		function & onAddArea(&$core, &$args)
		{
			return $this->call('area', 'add', $args);
		}

		function & onEditArea(&$core, &$args)
		{
			return $this->call('area', 'edit', $args);
		}

		function & onDeleteArea(&$core, &$args)
		{
			return $this->call('area', 'delete', $args);
		}

		// GROUPS
		
		function & getGroupRights($gid)
		{
			return $this->call('group', 'getgrouprights', $args);
		}

		function & onListGroupForm(&$core, &$args)
	    	{
			return $this->call('group', 'listform', $args);
		}

		function & onAddGroupRightForm(&$core, &$args)
		{
			return $this->call('group', 'addform', $args);
		}

	    	function & onAddGroupRight(&$core, &$args)
	    	{
    			return $this->call('group', 'add', $args);
		}

	    	function & onDeleteGroupRight(&$core, &$args)
	    	{
    			return $this->call('group', 'delete', $args);
		}

		// USERS
		
		function & onListUserForm(&$core, &$args)
		{
			$users =& $core->call('user', 'listasoptions');
			if ($this->isError($users)) return $this->raiseError($users);
			
			$core->smarty->assign('action', iCore::URL($this->name, 'listuser'));
			$core->smarty->assign_by_ref('users', $users);
			
			return true;
		}

		function & onAddUserRightForm(&$core, &$args)
		{
	    		$this->call('user', 'addform', $args);
		}

		function & onListUser(&$core, &$args)
	    	{
	    		$this->call('user', 'listform', $args);
		}

	    	function & onAddUserRight(&$core, &$args)
    		{
    			return $this->call('user', 'add', $args);
		}
		
	    	function & onDeleteUserRight(&$core, &$args)
	    	{
    			return $this->call('user', 'delete', $args);
		}
	}
?>
