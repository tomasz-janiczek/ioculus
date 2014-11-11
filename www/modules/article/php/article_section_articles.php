<?php

	class iModule_Article_Section_Articles extends iModuleDB
	{
		var $_dbTable = 'article_section_articles';

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

		function & get($id)
		{
			$this->db->reset();
			$this->db->setTable($this->_dbTable);
			$this->db->setWhere("article_id = {$id}");
			$section =& $this->db->getAll(0,1);
			if ($section === false) return $this->raiseError(null, IERROR_DB_QUERY);
			if (empty($section)) return $this->raiseError(null, IERROR_NOT_FOUND);
			
			return $section[0];
		}

		function & onExists(&$core, &$args)
		{
			return $this->get($args['id']);
		}		

		function & onList(&$core, &$args)
		{
			if (!empty($args['id'])) $this->db->setWhere("section_id = {$args['id']}");

			$result =& $this->db->getAll();
			if ($result === false) return $this->raiseError(null, IERROR_DB_QUERY);
			if (empty($result)) return array();

			if (empty($args['return'])) $args['return'] = 'raw';

			$sections = array();

			switch ($args['return']) {
			case 'raw':
			default:
				$sections = $result;
				break;
			}
			
			return $sections;
		}

		function & onEdit(&$core, &$args)
		{
			return $this->raiseError(null, IERROR_NOT_SUPPORTED);
		}

		function & onDeleteSingle(&$core, &$args)
		{
			$params = explode(':', $args['id']);
			if (empty($params)) return $this->raiseError(null, IERROR_PARAMS);
			
			if ($this->db->remove(array('section_id' => $params[0], 'article_id' => $params[1])) === false)
				return $this->raiseError(null, IERROR_DB_DELETE);
				
			return true;
		}

		function & onDelete(&$core, &$args)
		{
			if (!strpos(':', $args['id'])) {
				if ($this->db->remove($args['id'], 'article_id') === false)
					return $this->raiseError(null, IERROR_DB_DELETE);
			} else return parent::onDelete($core, $args);
		}
	}

?>
