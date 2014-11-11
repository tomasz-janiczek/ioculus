<?php

	define('IGROUP_GROUP',		0);
	define('IGROUP_ROLE',		1);

	class iModule_Group extends iModuleDB
	{
		var $_dbTable = 'liveuser_groups';
		var $groupTypes = array(
			IGROUP_GROUP => 'Grupa',
			IGROUP_ROLE => 'Rola'
		);
	
		function & onGetRoles(&$core, &$args)
		{
			$this->db->reset();
			$this->db->setTable('liveuser_groups');
			$this->db->setSelect('group_define_name AS name, group_description AS description, group_id AS id');
			$this->db->setWhere('group_type = ' . IGROUP_ROLE);
			$result =& $this->db->getAll();
			if (empty($result)) return array();
			if ($result === false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			if (!empty($args['return'])) {
				switch ($args['return']) {
				case 'list':
					$list = array();
					foreach ($result as $val) $list[$val['id']] = $val['name'];
					return $list;
					break;
					
				default:
					return $result;
					break;
				}
			}
			
			return $result;
		}

		function & onExists(&$core, &$args)
    		{
			if (is_numeric($args['id']))
				$params = array('filters' => array('group_id' => $args['id']));
			else if (is_string($args['id']))
				$params = array('filters' => array('group_define_name' => $args['id']));
			else return false;
			
			$group =& $core->userAdmin->perm->getGroups($params);
			if ($group === false || empty($group)) return false;
			
			if (!empty($args['all'])) return $group[0];
			else return $group[0]['group_define_name'];
		}

		function & onListForm(&$core, &$args)
		{
			$this->paginate->setTotal($this->onCount($core, $args));
			
			$filters = array(
				'offset' => $this->paginate->getIndex(),
				'limit' => $this->paginate->getLimit(),
				'order' => 'group_define_name',
				'fields' => array('group_id', 'group_type', 'group_define_name', 'group_description')
			);
			$groups =& $core->userAdmin->perm->getGroups($filters);
			if ($groups === false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			foreach ($groups as $key => $val) $groups[$key]['group_type_name'] = $this->groupTypes[$val['group_type']];

			$core->smarty->assign_by_ref('groups', $groups);
			
			return true;
		}
	
		function & onAddForm(&$core, &$args)
	    	{		
			$core->smarty->assign('action', iCore::URL($this->name, 'add'));
			$core->smarty->assign('group_types', $this->groupTypes);
			
			return true;
	    	}

	    	function & onEditForm(&$core, &$args)
    		{
			$group =& $core->userAdmin->perm->getGroups(array('filters' => array('group_id' => $args['id'])));
			if ($group === false) return $this->raiseError('Grupa o id=' . $args['id'] . ' nie istnieje');

			$core->smarty->assign('action', iCore::URL($this->name, 'edit', array('id' => $args['id'])));
			$core->smarty->assign('group_types', $this->groupTypes);
			$core->smarty->assign_by_ref('group', $group[0]);
			
			return true;
	    	}

	    	function & onDetails(&$core, &$args)
	    	{
			$group =& $core->userAdmin->perm->getGroups(array('filters' => array('group_id' => $args['id'])));
			if ($group === false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			$this->paginate->setTotal($this->onCount($core, $params = array('filters' => "group_id={$group[0]['group_id']}")));

			$params = array(
				'offset' => $this->paginate->getIndex(),
				'limit' => $this->paginate->getLimit(),
				'filters' => array('group_id' => $group[0]['group_id']),
			);
			$members =& $core->userAdmin->getUsers($params);
			if ($members === false) return $this->raiseError(null, IERROR_DB_QUERY);

			$core->smarty->assign_by_ref('group', $group[0]);
			$core->smarty->assign_by_ref('members', $members);
			
			return true;
		}

	    	function & onList(&$core, &$args)
    		{
			$params = array('fields' => array('group_id', 'group_define_name'));
			if (!empty($args['filters'])) $params['filters'] =& $args['filters'];
			if (empty($args['return'])) $args['return'] = 'options';

			$result =& $core->userAdmin->perm->getGroups($params);
			if ($result === false) return $this->raiseError(null, IERROR_DB_QUERY);
			if (empty($result)) return $result;
			
			switch ($args['return']) {
			case 'options':
			default:
				$options = array();
				foreach ($result as $value) {
					$id = $value['group_id'];
					$name = $value['group_define_name'];
					$options[$id] = $name;
				}
				break;
				
			case 'raw':
				$options =& $result;
				break;
			}

			return $options;    		
    		}

	    	function & onAdd(&$core, &$args)
    		{
    			if ($this->onExists($core, $params = array('id' => $args['name']))) return $this->raiseError(null, IERROR_EXISTS);
	    		
			$group = array(
				'group_define_name' => $args['name'],
				'group_description' => $args['description']
			);
			if (!empty($args['type'])) $group['group_type'] = $args['type'];
			
			$group =& $core->userAdmin->perm->addGroup($group);
			if ($group === false) return $this->raiseError(null, IERROR_DB_INSERT);
			
			return true;
		}

		function & onEdit(&$core, &$args)
		{
    			$group =& $this->onExists($core, $params = array('id' => $args['name'], 'all' => true));
    			if ($group && $group['group_id'] != $args['id']) return $this->raiseError(null, IERROR_EXISTS);
	    		
			$filters = array('group_id' => $args['id']);
			$data = array(
				'group_define_name' => $args['name'],
				'group_description' => $args['description'],
			);
			if (!empty($args['type'])) $data['group_type'] = $args['type'];

			$result =& $core->userAdmin->perm->updateGroup($data, $filters);
			if ($result === false) return $this->raiseError(null, IERROR_DB_UPDATE);
			
			return true;
		}

    		function & onDeleteSingle(&$core, &$args)
    		{
	    		if (is_numeric($args['id']))
		    		$params = array('group_id' => $args['id']);
	    		else if (is_string($args['id']))
		    		$params = array('group_define_name' => $args['id']);
		    	else return $this->raiseError(null, IERROR_PARAMS);
		    	
			$result =& $core->userAdmin->perm->removeGroup($params);
			if ($result === false) return $this->raiseError(null, IERROR_DB_REMOVE);
			
			return true;
		}

		// GROUP USERS
		
		function & onAddGroupUserForm(&$core, &$args)
	    	{
	    		return $this->call('user', 'addform', $args);
	    	}		

		function & onAddGroupUser(&$core, &$args)
	    	{
	    		return $this->call('user', 'add', $args);
	    	}		

		function & onDeleteGroupUser(&$core, &$args)
	    	{
	    		return $this->call('user', 'delete', $args);
	    	}		
	}

?>
