<?php

	class iModule_Library extends iModule
	{
		var $textTypeId = -1;
		var $articleTypeId = -1;
		var $newsTypeId = -1;
		var $communityOfferTypeId = -1;
		var $developerOfferTypeId = -1;
		
		var $offersPerPage = 6;
		var $pageLength = 1024;
		
		var $_sectionCache = array(
			'e-GIE' => 0
		);

		function & _onLoad(&$core, &$args)
		{			
			return true;
		}

		function & onMain(&$core, &$args)
		{
			$db =& $core->getModuleDatabase('article');
			
			$db->reset();
			$db->setTable('article');
			$db->setSelect('article.id AS id, article_section.id AS section_id');
			$db->addJoin('article_section', 'article_section.id=article.section_id');
			$db->setWhere("article_section.type=(SELECT article_type.id FROM article_type WHERE article_type.name='article')");
			$db->addOrder('article.date', true);
			$db->addOrder('article.id', false);
			$articles =& $db->getCol('article.id');
//			print $db->getQueryString();
//			die();
//		var_dump::display($articles);
			if ($articles === false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			if (empty($args['id'])) $args['id'] = $articles[0];
			else $articles[] = $args['id'];
			
			$ids = array_slice($articles, 0, 3);
			$list = implode(',', $articles);
			if (!in_array($args['id'], $ids)) $ids[] = $args['id'];
			unset($articles);
			
//			var_dump::display($list);

			$db->reset();
			$solutionId = $db->get($args['id'], 'solution_item_id');

			if ($solutionId > 0 && !in_array($solutionId, $ids)) $ids[] = $solutionId;
			
			$db->reset();
			$db->setSelect("article.id, article.title, article.date, article.solution_item_id, article.archive_item_id, article_section.type, article_section.name, article_section.id, liveuser_users.handle, archive_item.name, archive.name, IF(article.id IN (" . implode(',', $ids) . "), article.description, '') AS description");
			$db->addJoin('article_section', 'article.section_id = article_section.id');
			$db->addJoin('archive_item', 'archive_item.id = article.gallery_item_id', 'left');
			$db->addJoin('archive', 'archive.id = archive_item.archive_id', 'left');
			$db->addJoin('liveuser_perm_users', 'liveuser_perm_users.perm_user_id = article.author_id');
			$db->addJoin('liveuser_users', 'liveuser_users.authUserId = liveuser_perm_users.auth_user_id');
			$db->setWhere("article.id IN ({$list})");
			$db->addOrder('article.date', true);
			$db->addOrder('article.id', false);

			$tSections =& $db->getAll();
//			print $db->getQueryString();
//			var_dump::display($tSections);

			$news = array();
			foreach ($tSections as $key => $section) {
				$news[] =& $tSections[$key];
				if (count($news) >= 3) break;
			}

			foreach ($tSections as $key => $value) {
				if ($value['id'] == $args['id']) {
					$prev_news =& $tSections[$key];
					break;
				}
			}

			$this->db->reset();
			$this->db->setTable('article_page');
			$this->db->setWhere("article_id = {$prev_news['id']}");
			$prev_news['page_count'] = $this->db->getCount();

//			var_dump::display($prev_news);

			if ($prev_news['solution_item_id'] > 0) {
				foreach ($tSections as $key => $value) {
					if ($value['id'] == $prev_news['solution_item_id']) {
						$prev_news['solution'] = $tSections[$key];
						break;
					}
				}
			}
			
			$sections = array();
			$egie_news = array();
			foreach ($tSections as $key => $section) {
				$sectionId = $section['_section_id'];
				$sectionName = $section['_section_name'];
				unset($section['_section_id']);
				unset($section['_section_name']);
				
				if (!empty($section['_item_name'])) {
					$tSections[$key]['image'] = $core->call('archive', 'getpath', array('name' => $section['_archive_name']));
					$tSections[$key]['image'] = iVFS::buildPath(array($tSections[$key]['image'], $tSections[$key]['_item_name']));
				}

				if ($section['_section_type'] != 45) continue;
				
				if (!isset($sections[$sectionId])) $sections[$sectionId] = array();
				$sections[$sectionId]['name'] = $sectionName;
				if (empty($section)) continue;
				if (!isset($sections[$sectionId]['articles'])) $sections[$sectionId]['articles'] = array();
				$sections[$sectionId]['articles'][] =& $tSections[$key];
				
				if (empty($egie_news) && $sectionId == $this->_sectionCache['e-GIE'])
					$egie_news =& $sections[$sectionId]['articles'];
			}
			unset($tSections);
			
//			var_dump::display($sections);

			if (!empty($args['page'])) {
				$this->db->reset();
				$this->db->setTable('article_page');
				$this->db->setSelect('content');
				$this->db->addWhere("article_id = {$args['id']}");
				$this->db->addWhere("number = {$args['page']}");
				$result =& $this->db->getAll();
//				var_dump::display($result);
//				print('Query: [' . $this->db->getQueryString() . ']<br/>');
				if ($result) $core->smarty->assign_by_ref('pageContent', $result[0]['content']);
				$core->smarty->assign('pageid', $args['page']);
				
				SmartyPaginate::connect();
				SmartyPaginate::setUrl(iCore::URL($this->name, 'main', array('id' => $args['id'])));
				SmartyPaginate::setUrlVar('page');
				SmartyPaginate::setTotal($prev_news['page_count']);
				SmartyPaginate::setLimit(1);
				SmartyPaginate::assign($core->smarty);
			}
						
			$articleOptions = array();
			if ($core->checkRightByName('article', 'editform'))
				$articleOptions[iCore::URL('article', 'editform', array('id' => $prev_news['id']))] = 'Edytuj';
			if ($core->checkRightByName('article', 'delete'))
				$articleOptions[iCore::URL('article', 'delete', array('id' => $prev_news['id']))] = 'Usuń';
			if (!empty($articleOptions)) $core->smarty->assign_by_ref('article_options', $articleOptions);

			$core->smarty->assign_by_ref('prev_news', $prev_news);
			$core->smarty->assign_by_ref('news', $news);
			$core->smarty->assign_by_ref('egie_news', $egie_news);
			$core->smarty->assign_by_ref('chapters', $sections);
			
			return true;
		}
		
		
		function & onIdea(&$core, &$args)
		{
			$article =& $core->call('article', 'get', array('id' => array(93,95)));
			if ($this->isError($article)) return $article;

			$newses =& $core->call('article', 'get', array('id' => array(97,99)));
			if ($this->isError($article)) return $newses;

			$core->smarty->assign_by_ref('article', $article);
			$core->smarty->assign_by_ref('newses', $newses);
			
//			var_dump::display($article);

/*			$this->db->reset();
			$this->db->setTable('article');
			$this->db->setSelect('article.*, liveuser_users.handle AS author, archive_item.name, archive.name');
			$this->db->addJoin('article_section', 'article.section_id = article_section.id');
			$this->db->addJoin('liveuser_perm_users', 'liveuser_perm_users.perm_user_id = article.author_id');
			$this->db->addJoin('liveuser_users', 'liveuser_users.authUserId = liveuser_perm_users.auth_user_id');
			$this->db->addLeftJoin('archive_item', 'archive_item.id = article.gallery_item_id');
			$this->db->addLeftJoin('archive', 'archive.id = archive_item.archive_id');
			$this->db->addWhere('article.section_id = 13');
			$this->db->addOrder('article.date', true);
			
			$news =& $this->db->getAll(0, 3);

//			print($this->db->getQueryString());			
//			var_dump::display($news);
			
			foreach ($news as $key => $value) {
				$news[$key]['image'] = $core->call('archive', 'getpath', array('name' => $value['_archive_name']));
				$news[$key]['image'] = iVFS::buildPath(array($news[$key]['image'], $news[$key]['_item_name']));
			}

			$section1 =& $core->call('article', 'listasarray', array('params' => array('filters' => array('id' => 34))));
			if ($this->isError($section1)) return $this->raiseError($section1);

			$section2 =& $core->call('article', 'listasarray', array('params' => array('filters' => array('id' => 35))));
			if ($this->isError($section2)) return $this->raiseError($section2);

			$core->smarty->assign_by_ref('news', $news);
			$core->smarty->assign_by_ref('section1', $section1);
			$core->smarty->assign_by_ref('section2', $section2); */
			
			return true;
		}

		function & onOffer(&$core, &$args)
		{
			$db =& $core->getModuleDatabase('article');
			
			$this->db->setSelect('article.id, article.title, article.date');
			$this->db->addJoin('article_section', 'article.section_id = article_section.id');
			$this->db->addWhere("article_section.type = 44");
			$this->db->addOrder('article.date', true);
			
			$newses =& $this->db->getAll(0, 10);
			
			$events = array();
			foreach ($newses as $news) {
				$date = date("m.d.Y", strtotime($news['date']));
				if (!isset($events[$date])) $events[$date] = array();
				$events[$date][] = array(
					'title' => $news['title'],
					'link' => iCore::URL('library', 'main', array('id' => $news['id']))
				);
			}
			unset($newses);

			$developer_tools = array(
				array(
					'name' => 'Ankieta Termomodernizacyjna',
					'description' => 'Zautomatyzowane gromadzenie informacji nt. audytu energetycznego'
				),
				array(
					'name' => 'Sklep Internetowy',
					'description' => 'Skorzystaj z możliwości nowej gospodarki, prowadź sprzedaż w Internecie'
				),
				array(
					'name' => 'Portal Przedsiębiorcy',
					'description' => 'Szybki, skuteczny i dziecinnie prosty sposób na zaistnienie w Globalnej Sieci'
				),
			);

			$developer_members = array(
  				array(
  					'name' => 'Megaterm S.A',
  					'link' => 'http://www.megaterm.com.pl'
  				),
				array(
					'name' => 'ESP Usługi',
					'link' => 'http://www.esp-uslugi.com.pl'
				),
				array(
					'name' => 'ARR Arreks S.A.',
					'link' => 'http://www.kleszczow.egie.com.pl'
				),
				array(
					'name' => 'ZUT Sp. z o.o.',
					'link' => 'http://www.zut.zagorz.net'
				),
				array(
					'name' => 'ELJOT Electronic',
					'link' => 'http://www.eljotelectronic.republika.pl'
				),
			);
				
			$community_tools = array(
				array(
					'name' => 'e-Przetarg',
					'description' => 'Znajdź błyskawicznie najkorzystniejszą ofertę. Wybierz dewelopera, który wykona dla Ciebie wybrane zadanie!'
				),
				array(
					'name' => 'Portal Gminny',
					'description' => 'Twojej gminie brakuje własnej strony WWW? A może aktualna nie spełnia Twoich oczekiwań?'
				),
				array(
					'name' => 'Liczniki Online',
					'description' => 'Zbij koszty działalności swojej gminy - odczytuj liczniki energii, gazu i wody via sieć Internet'
				),
			);

			$community_members = array(
				array(
					'name' => 'Kleszczów',
					'link' => 'http://www.kleszczow.pl'
				),
				array(
					'name' => 'Gierałtowice',
					'link' => 'http://www.gieraltowice.pl'
				),
				array(
					'name' => 'Zagórz',
					'link' => 'http://www.zagorz.net'
				),
				array(
					'name' => 'Strzelce Opolskie',
					'link' => 'http://www.strzelceopolskie.pl'
				),
			);
			
			if ($args['for'] == 'community') {
				$members =& $community_members;
				$tools =& $community_tools;
				$members_title = 'Gminy e-GIE';
				$tools_title = 'Narzędzia gmin';
				$typeId = $this->communityOfferTypeId;
			} else {
				$members =& $developer_members;
				$tools =& $developer_tools;
				$members_title = 'Deweloperzy e-GIE';
				$tools_title = 'Narzędzia deweloperów';
				$typeId = $this->developerOfferTypeId;
			}
			
//			foreach ($members as $key => $value) $members[$key]['name'] = 'Gmina ' . $value['name'];

			$db->reset();	
			$db->setTable('article_section');		
			$db->setSelect('id, name AS title, description, gallery_item_id, archive_item.name AS gallery_item, archive.name AS gallery_name');
			$db->addLeftJoin('archive_item', 'archive_item.id = article_section.gallery_item_id');
			$db->addLeftJoin('archive', 'archive.id = archive_item.archive_id');
			$db->addWhere("type = {$typeId}");
			$solutions =& $db->getAll(0, $this->offersPerPage);
//			print($db->getQueryString());
			if ($solutions == false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			$ids = array();
			foreach ($solutions as $value) $ids[] = $value['id'];
			
//			var_dump::display($ids);
			
			foreach ($solutions as $key => $value) {
				if (!empty($value['gallery_item'])) {
					$path = $core->call('archive', 'getpath', array('name' => $value['gallery_name']));
					$solutions[$key]['gallery_item'] = iVFS::buildPath(array($path, $value['gallery_item'])); 
				}
				$db->reset();
				$db->setTable('article');
				$db->setSelect('id, title, section_id');
				$db->setWhere("section_id = {$value['id']}");
				$solutions[$key]['services'] =& $db->getAll();
//				print $db->getQueryString();
			}
						
//			var_dump::display($solutions);

			if (!empty($args['id'])) {
				$db->reset();
				$db->setTable('article');
				$db->setSelect('title, content');
				$service =& $db->get($args['id']);
				if ($service == false) return $this->raiseError(null, IERROR_DB_QUERY);
				
				$core->smarty->assign_by_ref('service', $service);
			}

			$core->smarty->assign('members_title', $members_title);
			$core->smarty->assign('tools_title', $tools_title);
			$core->smarty->assign_by_ref('events', $events);
			$core->smarty->assign_by_ref('tools', $tools);
			$core->smarty->assign_by_ref('members', $members);
			$core->smarty->assign_by_ref('solutions', $solutions);
			
			return true;
		}

		function & onOfferDev(&$core, &$args)
		{
			$this->db->setSelect('article.id, article.title, article.date');
			$this->db->addJoin('article_section', 'article.section_id = article_section.id');
			$this->db->addWhere("article_section.type = 44");
			$this->db->addOrder('article.date', true);
			
			$newses =& $this->db->getAll(0, 10);
			
			$events = array();
			foreach ($newses as $news) {
				$date = date("m.d.Y", strtotime($news['date']));
				if (!isset($events[$date])) $events[$date] = array();
				$events[$date][] = array(
					'title' => $news['title'],
					'link' => iCore::URL('library', 'main', array('id' => $news['id']))
				);
			}
			unset($newses);
			
			$tools = array(
				array(
					'name' => 'Ankieta Termomodernizacyjna',
					'description' => 'Zautomatyzowane gromadzenie informacji nt. audytu energetycznego'
				),
				array(
					'name' => 'Sklep Internetowy',
					'description' => 'Skorzystaj z możliwości nowej gospodarki, prowadź sprzedaż w Internecie'
				),
				array(
					'name' => 'Portal Przedsiębiorcy',
					'description' => 'Szybki, skuteczny i dziecinnie prosty sposób na zaistnienie w Globalnej Sieci'
				),
			);

			$members = array(
  				array(
  					'name' => 'Megaterm S.A',
  					'link' => 'http://www.megaterm.com.pl'
  				),
				array(
					'name' => 'ESP Usługi',
					'link' => 'http://www.esp-uslugi.com.pl'
				),
				array(
					'name' => 'ARR Arreks S.A.',
					'link' => 'http://www.kleszczow.egie.com.pl'
				),
				array(
					'name' => 'ZUT Sp. z o.o.',
					'link' => 'http://www.zut.zagorz.net'
				),
				array(
					'name' => 'ELJOT Electronic',
					'link' => 'http://www.eljotelectronic.republika.pl'
				),
			);

			$solutions = array(
				array(
					'title' => 'Handel',
					'description' => 'Poszerz swój rynek zbytu na całą Polskę i świat - sprzedawaj usługi i produkty via portal e-GIE',
					'image' => 'www/images/illustration_21.jpg'
				),
				array(
					'title' => 'Współpraca',
					'description' => 'Skorzystaj z możliwości, jakie daje e-GIE - nawiąż współpracę z dowolną gminą bez zbędnej biurokracji ',
					'image' => 'www/images/illustration_17.jpg'
				),
				array(
					'title' => 'Informacja',
					'description' => 'Dostęp do informacji witalnych dla Twojej firmy w ciągu ułamka sekundy - bądź na bieżąco i rozwijaj się',
					'image' => 'www/images/illustration_20.jpg'
				),
				array(
					'title' => 'Technologia',
					'description' => 'Obniż swoje koszty. Zrezygnuj z zakupu drogiego sprzętu i aplikacji - wynajmnij je od e-GIE przez sieć',
					'image' => 'www/images/illustration_15.jpg'
				),
				array(
					'title' => 'Promocja',
					'description' => 'Zadbaj o marketing własnej firmy - wypromuj ją wśród gmin członkowskich i innych deweloperów e-GIE',
					'image' => 'www/images/illustration_16.jpg'
				),
				array(
					'title' => 'Kontakt',
					'description' => 'Szybkie i intuicyjnie łatwe w obsłudze narzędzia do kontaktu z gminami i deweloperami z i poza Twojej branży',
					'image' => 'www/images/illustration_23.jpg'
				),
			);

			$core->smarty->assign_by_ref('events', $events);
			$core->smarty->assign_by_ref('tools', $tools);
			$core->smarty->assign_by_ref('members', $members);
			$core->smarty->assign_by_ref('solutions', $solutions);
			
			return true;
		}

/*		function & onStudium(&$core, &$args)
		{
			$db =& $core->getModuleDatabase('article');
			
			$db->setSelect('article.id AS id, article_section.id AS section_id');
			$db->addJoin('article_section', 'article_section.id = article.section_id');
			$db->addWhere("article_section.type = 2");
			$db->addWhere('article_section.id = 23');
			$db->addOrder('article.date', true);
			$db->addOrder('article.id', false);
			$articles =& $db->getCol('article.id');
			if ($articles == false) return $this->raiseError(null, IERROR_DB_QUERY);
//			print $db->getQueryString();
//			var_dump::display($articles);

			// Ouch! :P
			if (empty($args['id'])) $args['id'] = 54;
			else $articles[] = $args['id'];
			
			$ids = array_slice($articles, 0, 3);
			$list = implode(',', $articles);
			if (!in_array($args['id'], $ids)) $ids[] = $args['id'];
			unset($articles);

			$db->reset();
			$solutionId = $db->get($args['id'], 'solution_item_id');

			if ($solutionId > 0 && !in_array($solutionId, $ids)) $ids[] = $solutionId;
			
			$db->reset();
			$db->setSelect("article.id, article.title, article.date, article.solution_item_id, article.archive_item_id, article_section.type, article_section.name, article_section.id, liveuser_users.handle, archive_item.name, archive.name, IF(article.id IN (" . implode(',', $ids) . "), article.content, '') AS content");
			$db->addJoin('article_section', 'article.section_id = article_section.id');
			$db->addJoin('archive_item', 'archive_item.id = article.gallery_item_id', 'left');
			$db->addJoin('archive', 'archive.id = archive_item.archive_id', 'left');
			$db->addJoin('liveuser_perm_users', 'liveuser_perm_users.perm_user_id = article.author_id');
			$db->addJoin('liveuser_users', 'liveuser_users.authUserId = liveuser_perm_users.auth_user_id');
			$db->setWhere("article.id IN ({$list})");
			$db->addOrder('article.date', false);
			$db->addOrder('article.id', false);

			$tSections =& $db->getAll();
//			print $db->getQueryString();
//			var_dump::display($tSections);

			$news = array();
			foreach ($tSections as $key => $section) {
				$news[] =& $tSections[$key];
				if (count($news) >= 3) break;
			}

			foreach ($tSections as $key => $value) {
				if ($value['id'] == $args['id']) {
					$prev_news =& $tSections[$key];
					break;
				}
			}

//			var_dump::display($prev_news);

			if ($prev_news['solution_item_id'] > 0) {
				foreach ($tSections as $key => $value) {
					if ($value['id'] == $prev_news['solution_item_id']) {
						$prev_news['solution'] = $tSections[$key];
						break;
					}
				}
			}
			
			$sections = array();
			foreach ($tSections as $key => $section) {
				$sectionId = $section['_section_id'];
				$sectionName = $section['_section_name'];
				unset($section['_section_id']);
				unset($section['_section_name']);
				
				if (!empty($section['_item_name'])) {
					$tSections[$key]['image'] = $core->call('archive', 'getpath', array('name' => $section['_archive_name']));
					$tSections[$key]['image'] = iVFS::buildPath(array($tSections[$key]['image'], $tSections[$key]['_item_name']));
				}

				if ($section['_section_type'] != 2) continue;
				
				if (!isset($sections[$sectionId])) $sections[$sectionId] = array();
				$sections[$sectionId]['name'] = $sectionName;
				if (empty($section)) continue;
				if (!isset($sections[$sectionId]['articles'])) $sections[$sectionId]['articles'] = array();
				$sections[$sectionId]['articles'][] =& $tSections[$key];				
			}
			unset($tSections);
			
//			var_dump::display($sections);						
//			var_dump::display($prev_news);

			$core->smarty->assign_by_ref('news', $news);
			$core->smarty->assign_by_ref('prev_news', $prev_news);
			$core->smarty->assign_by_ref('chapters', $sections);
			
			return true;
		} */
		
		function & onStudium(&$core, &$args)
		{
			$section =& $core->call('article', 'sectionexists', array('id' => 23, 'all' => true));
			if ($section === false) return $this->raiseError("Sekcja nie istnieje");
		
			$db =& $core->getModuleDatabase('article');
			
			$db->reset();
			$db->setTable('article');
			$db->setSelect('id, title');
			$db->setWhere("section_id = {$section['id']}");
			$db->addOrder('date', false);
			$db->addOrder('id', false);
			$articles =& $db->getAll();
			if ($articles == false) return $this->raiseError(null, IERROR_DB_QUERY);
		
			$articles = array(
				0 => array('name' => 'Studium', 'articles' => $articles)
			);
		
			$letter =& $core->call('article', 'getpage', array('id' => 65, 'number' => 1));
			if ($this->isError($letter)) return $this->raiseError($letter);
		
			$core->smarty->assign_by_ref('deans_letter', $letter);
			$core->smarty->assign_by_ref('news', $news);
			$core->smarty->assign_by_ref('prev_news', $prev_news);
			$core->smarty->assign_by_ref('chapters', $articles);
			
			return true;
		}

		function & onKS(&$core, &$args)
		{
			$this->db->reset();
			$this->db->setTable('archive_item');
			$this->db->setSelect('id,name,description');
			$this->db->setWhere('archive_id=225');
			$files =& $this->db->getAll();
			if (!empty($files)) $core->smarty->assign_by_ref('files', $files);
					
			return true;
		}

		function & onSendMail(&$core, &$args)
		{
			$vars =& $args['vars'];
			
			$params = array(
				'template' => $args['template'],
				'address' => $args['address'],
				'subject' => $args['subject'],
				'fullname' => $vars['name'] . ' ' . $vars['lastname'],
				'from' => 'boguslaw.szewc@egie.pl',
				'from_name' => 'Bogusław Szewc :: Redaktor www.egie.pl',
				'reply_to' => 'boguslaw.szewc@egie.pl',
				'reply_to_name' => 'Bogusław Szewc :: Redaktor www.egie.pl',
				'vars' => &$vars
			);
			$result = $core->call('mailing', 'sendtemplate', $params);
			if ($this->isError($result)) return $this->raiseError($result);
			
			return true;
		}

		function & onSepRegister(&$core, &$args)
		{
			if (empty($args['agree'])) {
				return $this->raiseError('Do przeprowadzenia rejestracji niezbędna jest zgoda na przetwarzanie danych osobowych');
			}
	
			$args['handle'] = sprintf("%s.%s", $args['name'], $args['lastname']);
			if (strlen($args['handle']) > 32 || $core->call('user', 'exists', array('id' => $args['handle'])) != false)
				$args['handle'] = sprintf("%s", substr(md5($args['email'] . rand()), 16, 32));
			$args['passwd'] = sprintf("egie.%s", $args['handle']);
			$args['passwd_confirm'] = $args['passwd'];
			
			$id = $core->call('user', 'register', $args);
			if ($this->isError($id)) return $this->raiseError($id);
			
			unset($args['agree']);

			$group = $core->call('group', 'exists', array('id' => 'SEP', 'all' => true));
			if ($this->isError($group)) return $this->raiseError($group);

			$result = $core->call('group', 'addgroupuser', array('gid' => $group['group_id'], 'id' => $id));
			if ($this->isError($result)) return $this->raiseError($result);

			$handle = $args['handle'];
			unset($args['passwd'], $args['passwd_confirm'], $args['handle']);
			
			$result = $core->call('profile', 'addmultiple', array('id' => $id, 'prefs' => $args));
			if ($this->isError($result)) return $this->raiseError($result);

			$vars = array(
				'handle' => $handle,
				'confirm_url' => 'http://www.egie.pl/' . iCore::URL('library', 'activate', array('hash' => md5($handle), 'type' => 'sep'), null, false)
			);
			$vars = array_merge($vars, $args);
			
			$params = array(
				'template' => 'sep_please_confirm',
				'address' => $args['email'],
				'subject' => '"Nowoczesna energetyka i e-Gmina - połączenie przyszłości"',
				'fullname' => $args['name'] . ' ' . $args['lastname'],
				'vars' => $vars
			);
			$result = $core->call($this->name, 'sendmail', $params);
			if ($this->isError($result)) return $this->raiseError($result);
			
			$core->redirect(iCore::URL($this->name, 'sep_ok_form', array(), null, false));
			
			return true;
		}

		function & onKSRegister(&$core, &$args)
		{
			$args['handle'] = sprintf("%s.%s", $args['name'], $args['lastname']);
			if (strlen($args['handle']) > 32 || $core->call('user', 'exists', array('id' => $args['handle'])) != false)
				$args['handle'] = sprintf("%s", substr(md5($args['email'] . rand()), 16, 32));
			$args['passwd'] = sprintf("egie.%s", $args['handle']);
			$args['passwd_confirm'] = $args['passwd'];
			$args['agree'] = true;
			
			$id = $core->call('user', 'register', $args);
			if ($this->isError($id)) return $this->raiseError($id);
			
			$group = $core->call('group', 'exists', array('id' => 'KS', 'all' => true));
			if ($this->isError($group)) return $this->raiseError($group);

			$result = $core->call('group', 'addgroupuser', array('gid' => $group['group_id'], 'id' => $id));
			if ($this->isError($result)) return $this->raiseError($result);

			$handle = $args['handle'];
			unset($args['passwd'], $args['passwd_confirm'], $args['handle']);

			$result = $core->call('company', 'exists', array('id' => $args['company']));
			if ($result === false) {
				$params = array(
					'name' => $args['company'],
				);
				$result =& $core->call('company', 'add', $params);
				if ($this->isError($result)) return $this->raiseError($result);
				$args['company_id'] = $result;
			}
			unset($args['company']);
			
			$result = $core->call('profile', 'addmultiple', array('id' => $id, 'prefs' => $args));
			if ($this->isError($result)) return $this->raiseError($result);

			$vars = array(
				'handle' => $handle,
				'confirm_url' => 'http://www.egie.pl/' . iCore::URL('library', 'activate', array('hash' => md5($handle), 'type' => 'ks'), null, false)
			);
			$vars = array_merge($vars, $args);
			
			foreach ($vars as $key => $val) $vars[$key] = iconv('UTF-8', 'ISO-8859-2', $val);
			
			$params = array(
				'template' => 'ks_please_confirm',
				'address' => $args['email'],
				'subject' => '"Nowoczesna energetyka rozproszona i infrastruktura w e-gminach"',
				'fullname' => $args['name'] . ' ' . $args['lastname'],
				'vars' => $vars
			);
			$result = $core->call($this->name, 'sendmail', $params);
			if ($this->isError($result)) return $this->raiseError($result);

			$core->Message("Dziękujemy za rejestrację.<br/>Na adres {$args['email']} wysłany został właśnie list z potwierdzeniem i końcowymi instrukcjami.");
			
			return true;
		}

		function & onStudiumRegister(&$core, &$args)
		{
			if (empty($args['agree'])) {
				return $this->raiseError('Do przeprowadzenia rejestracji niezbędna jest zgoda na przetwarzanie danych osobowych');
			}
	
			$args['handle'] = sprintf("%s.%s", $args['name'], $args['lastname']);
			if (strlen($args['handle']) > 32 || $core->call('user', 'exists', array('id' => $args['handle'])) != false)
				$args['handle'] = sprintf("%s", substr(md5($args['email'] . rand()), 16, 32));
			$args['passwd'] = sprintf("egie.%s", $args['handle']);
			$args['passwd_confirm'] = $args['passwd'];
			
			$id = $core->call('user', 'register', $args);
			if ($this->isError($id)) return $this->raiseError($id);
			
			unset($args['agree']);

			$group = $core->call('group', 'exists', array('id' => 'studium', 'all' => true));
			if ($this->isError($group)) return $this->raiseError($group);

			$result = $core->call('group', 'addgroupuser', array('gid' => $group['group_id'], 'id' => $id));
			if ($this->isError($result)) return $this->raiseError($result);

			$handle = $args['handle'];
			unset($args['passwd'], $args['passwd_confirm'], $args['handle']);
						
			if (!empty($args['company_name'])) {
				$result = $core->call('company', 'exists', array('id' => $args['company_name']));
				if ($result === false) {
					$params = array(
						'name' => $args['company_name'],
						'address' => $args['company_address'],
						'city' => $args['company_city'],
						'nip' => $args['company_nip'],
						'phone' => $args['company_phone'],
						'fax' => $args['company_fax']
					);
					$result =& $core->call('company', 'add', $params);
					if ($this->isError($result)) return $this->raiseError($result);
					$args['company_id'] = $result;
				}
				unset($args['company_name'], $args['company_address'], $args['company_city'], $args['company_nip'],
					  $args['company_phone'], $args['company_fax']);
			}

			$result = $core->call('profile', 'addmultiple', array('id' => $id, 'prefs' => $args));
			if ($this->isError($result)) return $this->raiseError($result);
			
			$vars = array(
				'handle' => $handle,
				'confirm_url' => 'http://www.egie.pl/' . iCore::URL('library', 'activate', array('hash' => md5($handle), 'type' => 'studium'), null, false)
			);
			$vars = array_merge($vars, $args);
			
			$params = array(
				'template' => 'studium_please_confirm',
				'address' => $args['email'],
				'subject' => '[studium.egie.pl] Studium podyplomowe',
				'fullname' => $args['name'] . ' ' . $args['lastname'],
				'vars' => $vars
			);
			$result = $core->call($this->name, 'sendmail', $params);
			if ($this->isError($result)) return $this->raiseError($result);
			
			$core->Message("Dziękujemy za rejestrację.<br/>Na adres {$args['email']} wysłany został właśnie list z potwierdzeniem i końcowymi instrukcjami.");
			
			return true;
		}

		function & onSepActivate(&$core, &$args)
		{
			$args['type'] = 'sep';
			return $core->call($this->name, 'activate', $args);
		}

		function & onActivate(&$core, &$args)
		{
			switch ($args['type']) {
			case 'sep':
				$args['message'] = 'Uczestnictwo w seminarium potwierdzone. Dziękujemy.';
				break;

			case 'studium':
				$args['message'] = 'Zgłoszenie na studium zostało potwierdzone. Dziękujemy.';
				break;

			case 'ks':
				$args['message'] = 'Zgłoszenie na konferencję zostało potwierdzone. Dziękujemy.';
				break;
				
			default:
				return $this->raiseError('Parametry aktywacji niepoprawne');
			}
			
			$result = $core->call('user', 'activate', $args);
			if ($this->isError($result)) return $this->raiseError($result);
		
			return true;
		}

		function & onStudiumXLS(&$core, &$args)
		{
			$this->db->reset();
			$this->db->setTable('profile');
			$this->db->setSelect('profile.user_id AS id, profile.pref_id AS name, profile.pref_value AS value');
			$this->db->setWhere("user_id IN (SELECT perm_user_id FROM liveuser_groupusers WHERE group_id=(SELECT group_id FROM liveuser_groups WHERE group_define_name='studium'))");
			$this->db->setOrder('user_id');
			$result =& $this->db->getAll();
			if ($result == false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			$data = array();
			$hdr = array();
			foreach ($result as $val) {
				if (!in_array($val['name'], $hdr)) $hdr[] = $val['name'];
				
				if (!isset($data[$val['id']])) $data[$val['id']] = array();
				$data[$val['id']][$val['name']] = $val['value'];
			}
			
//			var_dump::display($result);
//			var_dump::display($hdr);
//			var_dump::display($data);
			
			unset($result);

//			return true;

			require_once('Spreadsheet/Excel/Writer.php');
			
			$xls =& new Spreadsheet_Excel_Writer();

			$hformat =& $xls->addFormat(array('bold' => true, 'Align' => 'center'));
			$format =& $xls->addFormat(array('Align' => 'center'));
			$worksheet =& $xls->addWorksheet();

			$i = 0;
			$j = 0;
			foreach ($hdr as $name)
				$worksheet->write($j, $i++, iconv("UTF-8", "ISO-8859-2//TRANSLIT", $name), $hformat);
			
			$j++;
			foreach ($data as $row) {
				$i = 0;
				foreach ($hdr as $optname) {
					if (!isset($row[$optname])) $value = '';
					else $value = iconv("UTF-8", "ISO-8859-2//TRANSLIT", unserialize($row[$optname]));
					$worksheet->write($j, $i++, $value, $format);
				}
				$j++;
			}

			$xls->send('studium_egie_pl.xls');
			$xls->close();
			
			return true;
		}

		function & onConversatory(&$core, &$args)
		{
			$this->db->reset();
			$this->db->setTable('article_section');
			$this->db->setSelect('id,name');
			$this->db->setWhere('type = 128');
			$this->db->setOrder('id', false);
			$result =& $this->db->getAll();
			if ($result == false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			$sectionIds = array();
			$sectionNames = array();
			foreach ($result as $val) {
				$id = $val['id'];
				$sectionIds[] = $id;
				if (!isset($sectionNames[$id])) $sectionNames[$id] = array('title' => $val['name'], 'id' => $id);
			}
			$sectionIds = implode(',', $sectionIds);

			$this->db->reset();
			$this->db->setTable('article');
			$this->db->setSelect('id,title');
			$this->db->setWhere("section_id IN ({$sectionIds})");
			$this->db->setOrder('article.date', true);
			$this->db->setOrder('article.id', true);
			$result =& $this->db->getAll(0, 10);
			if ($result == false) return $this->raiseError(null, IERROR_DB_QUERY);

			$newest = array();
			foreach ($result as $val) $newest[$val['id']] = $val['title'];
			
			$articles = array(
				array('name' => 'Konwersatorium', 'articles' => array()),
				array('name' => 'Zakresy tematyczne', 'articles' => $sectionNames),
				array('name' => 'Podziel się swoją wiedzą!', 'articles' => array())
			);
			
//			$core->smarty->clear_all_cache();
			$core->smarty->assign_by_ref('chapters', $articles);
			$core->smarty->assign_by_ref('newest', $newest);
			$core->smarty->assign_by_ref('topart', $newest);
			
			return true;
		}

		function & onConversatory1(&$core, &$args)
		{
			$this->paginate->setTotal($this->db->getCount());
		
			$this->db->reset();
			$this->db->setTable('article_section');
			$this->db->setSelect('id,name,description');
			$this->db->setWhere('type = 128');
			$this->db->setOrder('id', false);
			$result =& $this->db->getAll();
			if ($result == false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			$sectionIds = array();
			$sectionNames = array();
			$section = array();
			foreach ($result as $val) {
				$id = $val['id'];
				if ($id == $args['id']) $section = $val;
				$sectionIds[] = $id;
				if (!isset($sectionNames[$id])) $sectionNames[$id] = array('title' => $val['name'], 'id' => $id);
			}
			$sectionIds = implode(',', $sectionIds);

			$this->db->reset();
			$this->db->setTable('article');
			$this->db->setSelect('id,title');
			$this->db->setWhere("section_id IN ({$sectionIds})");
			$this->db->setOrder('article.date', true);
			$this->db->setOrder('article.id', true);
			$result =& $this->db->getAll(0, 10);
			if ($result == false) return $this->raiseError(null, IERROR_DB_QUERY);

			$newest = array();
			foreach ($result as $val) $newest[$val['id']] = $val['title'];

			$this->db->reset();
			$this->db->setTable('article');
			$this->db->setSelect('id,title,description, CONCAT(archive.path,archive_item.name) AS image');
			$this->db->addLeftJoin('archive_item', 'archive_item.id = article.gallery_item_id');
			$this->db->addLeftJoin('archive', 'archive.id = archive_item.archive_id');
			$this->db->setWhere("section_id={$args['id']}");
			$this->db->setOrder('article.date', true);
			$this->db->setOrder('article.id', true);
			$result =& $this->db->getAll($this->paginate->getIndex(), $this->paginate->getLimit());

			$articles = array(
				array('name' => 'Konwersatorium', 'url' => iCore::URL($this->name, 'conversatory'), 'articles' => array()),
				array('name' => 'Zakresy tematyczne', 'articles' => $sectionNames),
				array('name' => 'Podziel się swoją wiedzą!', 'articles' => array())
			);

			$core->smarty->assign_by_ref('chapters', $articles);
			$core->smarty->assign_by_ref('section', $section);
			$core->smarty->assign_by_ref('newest', $newest);
			$core->smarty->assign_by_ref('articles', $result);
			
			return true;
		}

		function & onConversatory2(&$core, &$args)
		{
			$this->db->reset();
			$this->db->setTable('article');
			$this->db->setSelect('article.*,CONCAT(archive.path,archive_item.name) AS image');
			$this->db->addLeftJoin('archive_item', "archive_item.id=article.gallery_item_id");
			$this->db->addLeftJoin('archive', 'archive.id=archive_item.archive_id');
			$this->db->setWhere("article.id={$args['id']}");
			$result =& $this->db->getAll();
//			print('Query: [' . $this->db->getQueryString() . ']<br/>');
			if ($result == false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			$prev_news = $result[0];
			$prev_news['page_count'] = $this->db->getCount();
			$core->smarty->assign_by_ref('prev_news', $prev_news);
			
			$action =& $this->getAction('conversatory2');
			$action->paginate->setTotal($prev_news['page_count']);

			$this->db->reset();
			$this->db->setTable('article_page');
			$this->db->setSelect('content');
			$this->db->addWhere("article_id = {$args['id']}");
			$this->db->addWhere("number = {$args['page']}");
			$result =& $this->db->getAll();
//				var_dump::display($result);
//				print('Query: [' . $this->db->getQueryString() . ']<br/>');
			if ($result != false) $core->smarty->assign_by_ref('pageContent', $result[0]['content']);
			$core->smarty->assign('pageid', $args['page']);
			

			$action->paginate->setUrl(iCore::URL($this->name, $action->name, array('id' => $args['id'])));
							
			return true;
		}

		function & onStudents(&$core, &$args)
		{
			$pattern = '%Skrypt%';

			$this->db->reset();
			$this->db->setTable('archive_item');
			$this->db->setSelect('archive_item.id,archive_item.name,archive_item.description');
			$this->db->setJoin('archive', "archive.name='students'");
			$this->db->addWhere("archive_item.archive_id=archive.id");
			$this->db->addWhere("archive_item.name NOT LIKE '{$pattern}'");
			$this->db->setOrder('id', true);
			$sfiles =& $this->db->getAll();
			if (!empty($sfiles)) $core->smarty->assign_by_ref('student_files', $sfiles);
			
			if ($core->checkRightByName('archive', 'view_students_files')) {
				$this->db->reset();
				$this->db->setTable('archive_item');
				$this->db->setSelect('archive_item.id,archive_item.name,archive_item.description');
				$this->db->setJoin('archive', "archive.name='students'");
				$this->db->setWhere("archive_item.archive_id=archive.id");
				$this->db->addWhere("archive_item.name LIKE '{$pattern}'");
				$this->db->setOrder('id', true);
				$files =& $this->db->getAll();
				if (!empty($files)) $core->smarty->assign_by_ref('files', $files);
			}
					
			return true;
		}

		function & onPrivacy(&$core, &$args)
		{
			$article =& $core->call('article', 'exists', $params = array('id' => 74, 'all' => true));
//			var_dump::display($article);
			$core->smarty->assign_by_ref('article', $article);
			
			return true;
		}

		function & onShow(&$core, &$args)
		{
			$article =& $core->call('article', 'get', $params = array('id' => $args['id']));
			$core->smarty->assign_by_ref('article', $article);
			
			return true;
		}
	}
?>
