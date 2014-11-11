<?php

	class iModule_Article extends iModuleDB
	{
		var $_dbTable = 'article';
		
		function & onList(&$core, &$args)
		{
			/* Using the 'return' => 'options' makes it possible, to implode all the id's into a linear list */
			$ids = $this->call('section_articles', 'list', $params = array('id' => $args['id'], 'return' => 'options'));
			if ($this->isError($ids)) return $ids;
			if (empty($ids)) return array();
		
			$ids = implode(',', $ids);
			
			$this->db->reset();
			$this->db->setTable($this->_dbTable);
			$this->db->setSelect('article.*, liveuser_users.handle AS handle');
			$this->db->setDontSelect('description, content');
			$this->db->addJoin('liveuser_perm_users', 'liveuser_perm_users.perm_user_id = article.author_id');
			$this->db->addJoin('liveuser_users', 'liveuser_users.authUserId = liveuser_perm_users.auth_user_id');
			$this->db->setWhere("article.id IN ({$ids})");
			$this->db->addOrder('article.date', true);
			$result =& $this->db->getAll();
//			print $this->db->getQueryString();
			if ($result === false) return $this->raiseError(null, IERROR_DB_QUERY);
			if (empty($result)) return array();
			
			if (empty($args['return'])) $args['return'] = 'raw';
			
			$list = array();
			
			switch ($args['return']) {
			case 'raw':
			default:
				$list =& $result;
				break;

			case 'options':
			default:
				foreach ($result as $val) $list[$val['id']] = $val['title'];
				break;
			}
			
			return $list;
		}

		function & onListForm(&$core, &$args)
		{
			$this->paginate->setTotal($this->onCount($core, $args));
			
			/* Unfortunately, I don't know how to get all the needed data in one query... */			
			/* First - let's get the articles, that are part of this section */

			$this->db->reset();
			$this->db->setTable($this->_dbTable);
			$this->db->setSelect("article.*");
			$this->db->setDontSelect('description, content');
			$this->db->setWhere("article.id IN (SELECT article_id FROM article_section_articles WHERE article_section_articles.section_id={$args['id']})");
			$this->db->addOrder('article.date', true);
			$this->db->setLimit($this->paginate->getIndex(), $this->paginate->getLimit());
			
			$result =& $this->db->getAll();
			if ($result === false) return $this->raiseError(null, IERROR_DB_QUERY);
			if (empty($result)) return true;

			/* Got them. Now we will create a list of users id's, that need to be resolved into user handles */

			$ids = array();
			foreach ($result as $val) {
				if (!in_array($val['author_id'], $ids)) $ids[] = $val['author_id'];
				if (!in_array($val['mod_author_id'], $ids)) $ids[] = $val['mod_author_id'];
			}
			$ids = implode(',', $ids);

			/* List ready. Let's fetch the handles from LiveUser */

			$this->db->reset();
			$this->db->setTable('liveuser_users');
			$this->db->setSelect("liveuser_perm_users.perm_user_id AS id, liveuser_users.handle AS handle");
			$this->db->addJoin('liveuser_perm_users', "liveuser_perm_users.auth_user_id = liveuser_users.authUserId");
			$this->db->setWhere("liveuser_perm_users.perm_user_id IN ({$ids})");

			$users =& $this->db->getAll();
			if ($users === false) return $this->raiseError(null, IERROR_DB_QUERY);
			if (empty($users)) return true;

			/* Change the structure of the result array into something more straightforward */

			$ids = array();
			foreach ($users as $val) $ids[$val['id']] = $val['handle'];

			/* Assign the resolved handles */

			foreach ($result as $key => $val) {
				if (isset($ids[$val['author_id']])) $result[$key]['author_handle'] = $ids[$val['author_id']];
				if (isset($ids[$val['mod_author_id']])) $result[$key]['mod_author_handle'] = $ids[$val['mod_author_id']];
			}

			$core->smarty->assign_by_ref('list', $result);
			
			return true;
		}

		function & onAddForm(&$core, &$args)
		{
			$sections =& $this->call('section', 'list', $params = array('return' => 'options'));
			if ($this->isError($sections)) return $sections;
							
			$core->smarty->assign('action', iCore::URL($this->name, 'add'));
			$core->smarty->assign_by_ref('sections', $sections);

			return true;
		}

		function & onEditForm(&$core, &$args)
		{
			$article =& $this->onGet($core, $args);
			if ($this->isError($article)) return $article;

			$sections =& $this->call('section', 'list', $params = array('return' => 'options'));
			if ($this->isError($sections)) return $sections;

			$section =& $this->call('section_articles', 'exists', $params = array('id' => $args['id']));
			if ($this->isError($section)) return $section;
			
			$core->smarty->assign('action', iCore::URL($this->name, 'edit', array('id' => $args['id'])));
			$core->smarty->assign_by_ref('article', $article);
			$core->smarty->assign_by_ref('sections', $sections);
			$core->smarty->assign('section_id', $section['section_id']);
			
			return true;
		}

		function & onAdd(&$core, &$args)
		{
			if (!$this->call('section', 'exists', $params = array('id' => $args['sectionid']))) return $this->raiseError(null, IERROR_NOT_FOUND);

			$sectionId = $args['sectionid'];
			unset($args['sectionid']);

			$args['author_id'] = $args['mod_author_id'] = $core->user->getProperty('perm_user_id');
			$args['date'] = $args['mod_date'] = date("y-m-d h:m:s");

			$id = parent::onAdd($core, $args);
			if ($this->isError($id)) return $id;
			
			return $this->call('section_articles', 'add', $params = array('section_id' => $sectionId, 'article_id' => $id));
		}

		function & onEdit(&$core, &$args)
		{
			if (!$this->call('section', 'exists', $params = array('id' => $args['sectionid']))) return $this->raiseError(null, IERROR_NOT_FOUND);

			$sectionId = $args['sectionid'];
			unset($args['sectionid']);

			$args['mod_author_id'] = $core->user->getProperty('perm_user_id');

			$result = parent::onEdit($core, $args);
			if ($this->isError($result)) return $result;

			$result = $this->call('section_articles', 'delete', $params = array('id' => $args['id']));
			if ($this->isError($result)) return $result;
			
			$result = $this->call('section_articles', 'add', $params = array('section_id' => $sectionId, 'article_id' => $args['id']));
			return $result;
			
		}

		function & onDeleteSingle(&$core, &$args)
		{		
			$result = $this->db->remove($args['id'], 'id');
			if ($this->isError($result)) return $result;	

			$result = $this->call('section_articles', 'delete', $params = array('id' => $args['id']));
			if ($this->isError($result)) return $result;

			return true;
		}

		function & onSetPriority(&$core, &$args)
		{
			if (strpos($args['id'], ':') === false) return $this->raiseError(null, IERROR_PARAMS);
			
			if (strpos($args['id'], ',') === false) $list = array($args['id']);
			else $list = explode(',', $args['id']);

			if (empty($list)) return $this->raiseError(null, IERROR_PARAMS);

			$query = "UPDATE {$this->_dbTable} SET priority = CASE id";
			foreach ($list as $key => $val) {
				$row = explode(':', $val);
				if (!is_numeric($row[0]) || !is_numeric($row[1]) || $row[0] <= 0 || $row[1] < 0) return $this->raiseError(null, IERROR_PARAMS);
				$query .= " WHEN {$row[0]} THEN {$row[1]}";
			}
			$query .= ' ELSE priority END';

			$result = $this->db->execute($query);
			if ($this->isError($result)) return $result;

			return true;
		}

		// SECTIONS

		function & onListSectionForm(&$core, &$args)
		{
			return $this->call('section', 'listform', $args);
		}

		function & onAddSectionForm(&$core, &$args)
		{			
			return $this->call('section', 'addform', $args);
		}

		function & onEditSectionForm(&$core, &$args)
		{			
			return $this->call('section', 'editform', $args);
		}

		function & onListSection(&$core, &$args)
		{
			return $this->call('section', 'list', $args);
		}

		function & onAddSection(&$core, &$args)
		{
			return $this->call('section', 'add', $args);
		}

		function & onEditSection(&$core, &$args)
		{
			return $this->call('section', 'edit', $args);
		}

		function & onDeleteSection(&$core, &$args)
		{
			return $this->call('section', 'delete', $args);
		}

		// SECTION TYPES

		function & onAddType(&$core, &$args)
		{
			return $this->call('type', 'add', $args);
		}

		function & onEditType(&$core, &$args)
		{
			return $this->call('type', 'edit', $args);
		}

		function & onDeleteType(&$core, &$args)
		{
			return $this->call('type', 'delete', $args);
		}

		function & onListTypeForm(&$core, &$args)
		{
			return $this->call('type', 'listform', $args);
		}

		function & onAddTypeForm(&$core, &$args)
		{
			return $this->call('type', 'addform', $args);
		}

		function & onEditTypeForm(&$core, &$args)
		{
			return $this->call('type', 'editform', $args);
		}

		// OTHER

		function & onSelectForm(&$core, &$args)
		{		
			$sections =& $this->getArticleSectionsAsOptions();
			if ($this->isError($sections)) return $this->raiseError($sections);
			
			$core->smarty->assign('editor_id', $args['editor_id']);
			$core->smarty->assign_by_ref('sections', $sections);
			
			return true;
		}

		function & onSelectFileForm(&$core, &$args)
		{		
			$this->db->setTable('archive_item');
			$this->db->setSelect('id, name');
			$this->db->setWhere("archive_item.archive_id = {$this->archiveId}");
			
			$result =& $this->db->getAll();
			if ($result === false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			$files = array();
			foreach ($result as $value) {
				$id = $value['id'];
				$files[$id] = $value['name'];
			}
			unset($result);
			
			$core->smarty->assign('editor_id', $args['editor_id']);
			$core->smarty->assign_by_ref('files', $files);
			
			return true;
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
