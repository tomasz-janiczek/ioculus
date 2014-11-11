<?php

	require_once('smarty/SmartyMenu.class.php');

	class iMenu extends SmartyMenu
	{
		var $menu = null;
		
		function & factory()
		{
			$obj =& new iMenu();
			return $obj;
		}

		function iMenu()
		{
			$this->addTopLevel('Strona główna', iCore::URL('news'));
			$this->addTopLevel('Platforma eGIE');
			$this->addTopLevel('Rozwiązania');
			$this->addTopLevel('Sieci biznesowe');
			$this->addTopLevel('Podserwisy');
//			$this->addTopLevel('Kontakt');
						
			$name = 'Sieci Biznesowe';
			$this->addFirstLevel($name, 'Sieć Projektów Demonstracyjnych');
			$this->addFirstLevel($name, 'Sieć Obiektów Inteligentnych');
			$this->addFirstLevel($name, 'Termomodernizacja');
		}

		function addTopLevel($name, $link = '', $position = null)
		{
			if (!is_string($name) || empty($name)) return false;
			
			SmartyMenu::initItem($item);
			SmartyMenu::setItemText($item, $name);
			if (!empty($link)) SmartyMenu::setItemLink($item, $link);
			SmartyMenu::addMenuItem($this->menu, $item, $position);
			
			return true;
		}

		function addFirstLevel($root, $name, $link = '')
		{
			if (!is_string($root) || empty($root) || !is_string($name) || empty($name)) return false;
			
			$link = html_entity_decode($link);
			foreach ($this->menu as $key => $value) {
				if ($value['text'] === $root) {
					SmartyMenu::initItem($item);
					SmartyMenu::setItemText($item, $name);
					if (!empty($link)) SmartyMenu::setItemLink($item, $link);
					SmartyMenu::addMenuItem($this->menu[$key]['submenu'], $item);
					return true;
				}
			}

			return false;
		}

		function addSecondLevel($root, $firstLevel, $name, $link)
		{
			if (!is_string($root) || empty($root) || !is_string($firstLevel) || empty($firstLevel) ||
			    !is_string($name) || empty($name) || !is_string($link) || empty($link)) return false;
			
			$link = html_entity_decode($link);
			foreach ($this->menu as $key => $value) {
				if ($value['text'] === $root) {
					if (empty($value['submenu'])) return false;
					foreach ($this->menu[$key]['submenu'] as $key1 => $value1) {
						if ($value1['text'] === $firstLevel) {
							SmartyMenu::initItem($item);
							SmartyMenu::setItemText($item, $name);
							SmartyMenu::setItemLink($item, $link);
							SmartyMenu::addMenuItem($this->menu[$key]['submenu'][$key]['submenu'], $item);
							return true;
						}
					}
				}
			}

			return false;
		}

		function topLevelExists($firstLevel)
		{
			if (empty($this->menu)) return false;
			
			foreach ($this->menu as $key => $value) {
				if ($value['text'] === $firstLevel) return true;
			}
			return false;
		}

		function firstLevelExists($firstLevel, $secondLevel)
		{
			if (empty($this->menu)) return false;
			
			foreach ($this->menu as $key1 => $value1) {
				if ($value1['text'] === $firstLevel) {
					if (empty($value1['submenu'])) return false;
					foreach ($value1['submenu'] as $key2 => $value2) {
						if ($value2['text'] === $secondLevel) return true;
					}
				}
			}
			return false;
		}
	}

?>
