<?php

	require_once('database.php');

	class iModule_Article_DB extends iModule_DB
	{
		function filterQuery()
		{
			$core =& $this->getCore();
			$rightList =& $core->user->getRightNamesList();
			
			$where = '';
			$match = array();
			$allowedSections = array();
			foreach ($rightList as $rightName => $rightId) {
				if (preg_match("/^article_view_section_(.*?)$/", $rightName, $match)) {
					if ($core->user->checkRight($rightId)) $allowedSections[] = $match[1];
				}
			}
			$allowedSections = implode(',', $allowedSections);
			if (empty($allowedSections)) $allowedSections = '-1';

			$query = $this->getQueryString();

//			print "<br/>QUERY START\n<br/>";
//			print $this->getQueryString() . '<br/>';
//			print "<br/>QUERY END\n<br/>";
			
			if (strpos($query, 'article.')) $this->addWhere("article.section_id IN ({$allowedSections})");
			if (strpos($query, 'article_section.')) $this->addWhere("article_section.id IN ({$allowedSections})");
		}		
	}

?>
