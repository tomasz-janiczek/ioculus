<?php
	
	class iModule_Right_Group extends iModuleDB
	{
		function & onListForm(&$core, &$args)
		{
			$groups =& $core->call('group', 'list', array('return' => 'options'));
			if ($this->isError($groups)) return $this->raiseError($groups);
			
			$core->smarty->assign('action', iCore::URL($this->name, 'listgroup'));
			$core->smarty->assign_by_ref('groups', $groups);
			
			return true;
		}

		function & onGetGroupRights(&$core, &$args)
		{
			$params = array(
				'fields' => array('right_id', 'right_define_name', 'right_description', 'area_id', 'area_define_name'),
				'filters' => array('group_id' => $args['id']),
				'selectable_tables' => array('groups', 'grouprights', 'rights', 'groupusers', 'areas', 'translations'),
				'by_group' => true,
			);
			$rights =& $core->userAdmin->perm->getRights($params);
			if ($rights === false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			return $rights;
		}

		function & onAddForm(&$core, &$args)
		{
			$group =& $core->call('group', 'exists', array('id' => $args['id'], 'all' => true));
			if ($this->isError($group)) return $group;

			$areas =& $this->call('area', 'list');
			if ($this->isError($areas)) return $areas;

			if (empty($args['area_id'])) {
				reset($areas);
				$args['area_id'] = key($areas);
			}

			$rights =& $this->call($this->name, 'list', array('return' => 'raw', 'id' => $args['area_id']));
			if ($this->isError($rights)) return $rights;
			
			$groupRights =& $this->onGetGroupRights($core, $args);
			if ($this->isError($groupRights)) return $groupRights;
			
			$groupRightIds = array();			
			foreach ($groupRights as $val) {
				if ($val['area_id'] == $args['area_id'] && $val['right_define_name'] == '*') {
					$rights = array();
					break;
				}
				$groupRightIds[] = $val['right_id'];
			}
			
			if (!empty($rights)) {
				foreach ($rights as $key => $val) if (in_array($val['right_id'], $groupRightIds)) unset($rights[$key]);
				$rights = array_values($rights);
			}
			
			$core->smarty->assign_by_ref('areas', $areas);
			$core->smarty->assign_by_ref('rights', $rights);
			$core->smarty->assign_by_ref('group_rights', $groupRights);
			$core->smarty->assign_by_ref('group', $group);
			
			return true;
		}

	    	function & onAdd(&$core, &$args)
    		{
			$params = array('group_id' => $args['id'], 'right_id' => $args['rid']);
			$granted =& $core->userAdmin->perm->grantGroupRight($params);
			if ($granted === false) return $this->raiseError(null, IERROR_DB_INSERT);
			
			return true;
		}

		function & onDeleteSingle(&$core, &$args)
    		{
			$result = $core->userAdmin->perm->revokeGroupRight(array('group_id' => $args['id'], 'right_id' => $args['rid']));
			if ($result === false) return $this->raiseError(null, IERROR_DB_REMOVE);
			
			return true;
		}
	}

?>
