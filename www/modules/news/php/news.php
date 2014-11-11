<?php

	class iModule_News extends iModule
	{
		var $newsPerPage = 3;
		var $articlesPerPage = 7;
	
		function & onIntro(&$core, &$args)
		{
			$this->db->setTable('article_section_articles');
			$this->db->setSelect('date AS date, content AS content, id AS id, title AS title, liveuser_users.handle AS handle');
			$this->db->addJoin('article', 'article.id = article_section_articles.article_id');
			$this->db->addJoin('liveuser_perm_users', 'liveuser_perm_users.perm_user_id = article.author_id');
			$this->db->addJoin('liveuser_users', 'liveuser_users.authUserId = liveuser_perm_users.auth_user_id');
			$this->db->addWhere("article_section_articles.section_id = 21");
			$this->db->addOrder('article.priority', false);
			$this->db->addOrder('article.date', true);
			
			$newses =& $this->db->getAll(0, $this->newsPerPage);
			if ($newses === false) return $this->raiseError(null, IERROR_DB_QUERY);
			if (!empty($newses)) $core->smarty->assign_by_ref('newses', $newses);

			$this->db->reset();
			$this->db->setTable('article_section_articles');
			$this->db->setSelect('id AS id, title AS title');
			$this->db->addJoin('article', 'article.id = article_section_articles.article_id');
			$this->db->addWhere("article_section_articles.section_id = 20");
			$this->db->addOrder('article.priority', false);
			$this->db->addOrder('article.date', true);
			
			$new =& $this->db->getAll(0,  $this->articlesPerPage);
			if ($new === false) return $this->raiseError(null, IERROR_DB_QUERY);
			if (!empty($new)) $core->smarty->assign_by_ref('problems', $new);

			$core->smarty->assign('handle', $core->user->getProperty('handle'));
			if (!empty($core->user->_profile['name']) && !empty($core->user->_profile['lastname']))
				$core->smarty->assign('fullname', $core->user->_profile['name'] . ' ' . $core->user->_profile['lastname']);
			else
				$core->smarty->assign('fullname', $core->user->getProperty('handle'));
			$core->smarty->assign('last_login', $core->user->getProperty('lastlogin'));

			if ($core->checkRightByName('sysmodman', 'adminpanel')) $core->smarty->assign('accessAdminPanel', true);
			if ($core->checkRightByName('userprofile', 'editform')) $core->smarty->assign('accessProfile', true);
			if ($core->checkRightByName('phpeasyproject')) $core->smarty->assign('accessProjectManager', true);
			
			return true;
		}

		function & onDetails(&$core, &$args)
		{
			$params = array('filters' => array('id' => $args['id']));
			$result =& $this->_container->get($params);
			if ($this->isError($result)) return $this->raiseError($result);
			$news = $result[0];
			unset($result);
			
			$result =& $core->call('gallery', 'itemexists', array('id' => $news['gallery_item_id'], 'all' => true));
			if ($this->isError($result)) return $this->raiseError($result);
			$news['image_path'] = $result['path'];
			unset($result);
			
			$miniMenu = array(
				array('name' => 'Edytuj', 'link' => iCore::URL($this->name, 'editform', array('id' => $args['id']))),
				array('name' => 'Usuń', 'link' => iCore::URL($this->name, 'delete', array('id' => $args['id'])))
			);

			$core->smarty->assign_by_ref('news', $news);
			$core->smarty->assign_by_ref('menu', $miniMenu);
			
			return true;
		}
	}

?>
