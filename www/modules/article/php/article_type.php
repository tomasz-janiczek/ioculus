<?php

	class iModule_Article_Type extends iModuleDB
	{
		var $_dbTable = 'article_type';
		var $explicitDelete = true;

		function & onListForm(&$core, &$args)
		{
			$list =& $this->db->getAll();
			if ($list === false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			$core->smarty->assign_by_ref('list', $list);
			
			return true;
		}

		function & onAddForm(&$core, &$args)
		{
			$core->smarty->assign('action', iCore::URL($this->name, 'addtype'));
			
			return true;
		}

		function & onEditForm(&$core, &$args)
		{
			$type =& $this->get($args['id']);
			if ($this->isError($type)) return $type;
				
			$core->smarty->assign('action', iCore::URL($this->name, 'edittype', $args));
			$core->smarty->assign_by_ref('type', $type);
						
			return true;
		}

		function & onList(&$core, &$args)
		{
			$result =& $this->db->getAll();
			if ($result === false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			$types = array();
			foreach ($result as $value)
				$types[$value['id']] = !empty($value['description']) ? $value['description'] : $value['name'];
				
			return $types;
		}

		function & onGetTypeId(&$core, &$args)
		{
			if (is_numeric($args['name'])) return $args['name'];
		
			$this->db->setTable('article_type');
			$this->db->setWhere("name = '{$args['name']}'");
			$id =& $this->db->getAll();
			if ($id == false) return $this->raiseError(null, IERROR_NOT_FOUND);
			
			return $id[0]['id'];
		}
	}

?>