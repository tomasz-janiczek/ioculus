<?php
	
	class iModule_Right_Area extends iModuleDB
	{
		var $_dbTable = 'liveuser_areas';
		
		function & onListForm(&$core, &$args)
		{
			$this->paginate->setTotal($this->onCount($core, $args));
			
			$filters = array(
				'offset' => $this->paginate->getIndex(),
				'limit' => $this->paginate->getLimit(),
				'orders' => array('area_define_name' => 'ASC'),
			);
			$areas =& $core->userAdmin->perm->getAreas($filters);
			if ($areas === false) return $this->raiseError(null, IERROR_DB_QUERY);

			$core->smarty->assign_by_ref('areas', $areas);
			
			return true;
		}

		function & onAddForm(&$core, &$args)
		{
			$core->smarty->assign('action', iCore::URL($this->name, 'addarea'));
			
			return true;
		}

		function & onEditForm(&$core, &$args)
		{
			$area =& $core->userAdmin->perm->getAreas(array('filters' => array('area_id' => $args['id'])));
			if ($area === false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			$core->smarty->assign('action', iCore::URL($this->name, 'editarea', array('id' => $args['id'])));
			$core->smarty->assign_by_ref('area', $area[0]);
			
			return true;
		}

		function & onExists(&$core, &$args)
		{
			$params = array();

			if (is_numeric($args['id']))
				$params = array('filters' => array('area_id' => $args['id']));
			else if (is_string($args['id']))
				$params = array('filters' => array('area_define_name' => $args['id']));
			else return false;

			$area =& $core->userAdmin->perm->getAreas($params);
			if ($area === false) return false;

			if ($args['all']) return $area[0];
			else return $area[0]['area_define_name'];
		}

		function & onList(&$core, &$args)
    		{
	    		$params = array();
			if (!empty($args['filters'])) $params['filters'] =& $filters;
			if (empty($args['return'])) $args['return'] = 'options';

			$result =& $core->userAdmin->perm->getAreas($params);
			if ($result === false) return $this->raiseError(null, IERROR_NOT_FOUND);

			$areas = array();

			switch ($args['return']) {
			case 'options':
			default:
				foreach ($result as $value) {
					$id = $value['area_id'];
					$name = $value['area_define_name'];
					$areas[$id] = $name;
				}
				break;

			case 'raw':
				$areas = $result;
				break;
			}
			
			return $areas;
		}

		function & onAdd(&$core, &$args)
		{
			$area = array(
				'application_id' => $this->_parent->getApplicationId(),
				'area_define_name' =>	$args['name'],
				'area_description'	=> $args['description']
			);
			$result =& $core->userAdmin->perm->addArea($area);
			if ($result === false) return $this->raiseError(null, IERROR_DB_INSERT);
			
			return $result;
		}

		function & onEdit(&$core, &$args)
		{
			$filters = array('area_id' => $args['id']);
			$data = array('area_define_name' => $args['name'], 'area_description' => $args['description']);

			$result =& $core->userAdmin->perm->updateArea($data, $filters);
			if ($result === false) return $this->raiseError(null, IERROR_DB_UPDATE);
			
			return true;
		}

		function & onDeleteSingle(&$core, &$args)
		{
			$result =& $core->userAdmin->perm->removeArea(array('area_id' => $args['id']));
			if ($result === false) return $this->raiseError(null, IERROR_DB_REMOVE);
			
			return true;
		}
	}
?>
