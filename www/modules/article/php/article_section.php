<?php

	class iModule_Article_Section extends iModuleDB
	{
		var $_dbTable = 'article_section';
		var $explicitDelete = true;
		var $sectionRightPrefix = 'section_view_';

		function & onListForm(&$core, &$args)
		{
			$list =& $this->onList($core, $args);
			if ($this->isError($list)) return $list;
			
			$types =& $this->call('type', 'list', array('return' => 'options'));
			if ($this->isError($types)) return $types;
		
			$types[0] = 'Wszystkie';
			
			$core->smarty->assign_by_ref('list', $list);
			$core->smarty->assign_by_ref('types', $types);
			$core->smarty->assign('type_selected', !empty($args['type']) ? $args['type'] : 0);

			return true;
		}

		function & onAddForm(&$core, &$args)
		{
			$types =& $this->call('type', 'list', array('return' => 'options'));
			if ($this->isError($types)) return $types;

			$core->smarty->assign('action', iCore::URL($this->name, 'addsection'));
			$core->smarty->assign_by_ref('types', $types);
			
			return true;
		}

		function & onEditForm(&$core, &$args)
		{
			$section =& $this->get($args['id']);
			if ($this->isError($section)) return $section;
	
			$types =& $this->call('type', 'list', array('return' => 'options'));
			if ($this->isError($types)) return $types;

			$core->smarty->assign_by_ref('section', $section);
			$core->smarty->assign('action', iCore::URL($this->name, 'editsection', array('id' => $args['id'])));
			$core->smarty->assign_by_ref('types', $types);
			
			return true;
		}

		function & exists($id)
		{
			$this->db->reset();
			$this->db->setTable($this->_dbTable);
			$this->db->setSelect('id');

			if (is_numeric($id)) $this->db->setWhere("id={$id}");
			else $this->db->setWhere("name='{$id}'");

			$result =& $this->db->getAll();
			if (!empty($result)) return true;
			else return false;
		}

		function & get($id, $all = true)
		{
			$this->db->reset();
			$this->db->setTable($this->_dbTable);
			$section =& $this->db->get($id);
			if ($section === false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			return $section;			
		}

		function & onList(&$core, &$args)
		{
			$this->db->reset();
			$this->db->setTable($this->_dbTable);
			$this->db->setSelect('article_section.*, article_type.id AS type_id, article_type.name AS type_name, article_type.description AS type_description');
			$this->db->setJoin('article_type', 'article_type.id = article_section.type');
			if (!empty($args['type'])) $this->db->setWhere("article_section.type = {$args['type']}");

			$result =& $this->db->getAll();
			if ($result === false) return $this->raiseError(null, IERROR_DB_QUERY);

			if (empty($args['return'])) $args['return'] = 'raw';

			$sections = array();

			switch ($args['return']) {
			case 'options':
				foreach ($result as $value) $sections[$value['id']] = $value['name'];
				break;

			case 'raw':
			default:
				$sections = $result;
				break;
			}
			
			return $sections;
		}

		function & onAdd(&$core, &$args)
		{
			if ($this->exists($args['name'])) return $this->raiseError(null, IERROR_EXISTS);
			
			if (!empty($args['image_id']) && !$core->call('archive', 'itemexists', array('id' => $args['image_id'])))
				return $this->raiseError(null, IERROR_NOT_FOUND);

			$id = parent::onAdd($core, $args);
			if ($this->isError($id)) return $id;
			
			$params = array(
				'areaid' => $this->name,
				'name' => $this->sectionRightPrefix . $id,
				'description' => "Przeglądanie sekcji '#{$id}'"
			);
			$result = $core->call('right', 'add', $params);
			if ($this->isError($result)) return $result;
			
			return $id;
		}
		
		function & onEdit(&$core, &$args)
		{		
			if (!empty($args['image_id']) && !$core->call('archive', 'itemexists', array('id' => $args['image_id'])))
				return $this->raiseError(null, IERROR_NOT_FOUND);
						
			return parent::onEdit($core, $args);
		}

		function & onDeleteSingle(&$core, &$args)
		{
			$result = $core->call('right', 'delete', array('id' => $this->sectionRightPrefix . $args['id']));

			$this->db->reset();
			$this->db->setTable('article');
			$this->db->remove($args['id'], 'section_id');

			return parent::onDeleteSingle($core, $args);
		}

		function & onUpdateSectionRights(&$core, &$args)
		{
			// Get all the sections
			$this->db->setTable('article_section');
			$this->db->setSelect('id, name');
			
			$result =& $this->db->getAll();
			if ($result === false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			// Get 'article' area id
			$tmp =& $core->call('right', 'areaexists', array('id' => $this->name, 'all' => true));
			if ($tmp === false) return $this->raiseError(null, IERROR_DB_QUERY);
			$aid = $tmp['area_id'];
			unset($tmp);
			
			// Check each section for the corresponding right. If it doesn't exist - create it.
			foreach ($result as $value) {
				$name = sprintf("%s%d", $this->sectionRightPrefix, $value['id']);
				if ($core->call('right', 'exists', array('aid' => $aid, 'rid' => $name))) continue;
				
				$params = array(
					'aid' => $aid,
					'name' => $name,
					'description' => "Przeglądanie sekcji {$value['name']}"
				);
				$ret =& $core->call('right', 'add', $params);
				if ($this->isError($ret)) return $this->raiseError($ret);
			}
			
			return true;
		}
	}

?>
