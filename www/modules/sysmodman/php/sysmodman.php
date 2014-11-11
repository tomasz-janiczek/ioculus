<?php

	class iModule_SysModman extends iModule
	{
		var $skelDir = 'skeleton';
		var $skelTemplate = 'skeleton.tpl';

		function & onListForm(&$core, &$args)
		{
			$allModules =& $core->moduleManager->getModuleList(true);
			$cachedModules =& $core->moduleManager->getCachedModules();

			$modules = array();

			foreach ($allModules as $key => $val) {
				$module = array('name' => $key, 'path' => $val);
				if (in_array($key, $cachedModules)) $module['cached'] = true;
				else $module['cached'] = false;

				$modules[] = $module;
			}			

			$core->smarty->assign_by_ref('modules', $modules);
			
			return true;
		}

		function & onDetailsForm(&$core, &$args)
		{
			$module =& $core->moduleManager->getModule($args['name']);
			if ($this->isError($module)) return $module;

			$actions =& $module->getActionList();
			if ($this->isError($actions)) return $actions;

			$core->smarty->assign_by_ref('module', $module);
			$core->smarty->assign('action_count', count($actions));
			$core->smarty->assign_by_ref('actions', $actions);
			
			return true;
		}

		function & onActionDetailsForm(&$core, &$args)
		{
			$module =& $core->moduleManager->getModule($args['modname']);
			if ($this->isError($module)) return $module;

			$action =& $module->getAction($args['actname']);
			if ($this->isError($action)) return $action;

			$core->smarty->assign_by_ref('module', $module);
			$core->smarty->assign_by_ref('action', $action);
			
			return true;
		}

		function & onCreate(&$core, &$args)
		{
			global $config;
			
			$root = $config['dir']['modules'] . DIRECTORY_SEPARATOR . $args['name'];
			if (file_exists($root)) return $this->raiseError(null, IERROR_FILE_EXISTS);
			
			$skelSrc = $this->uploadDir . DIRECTORY_SEPARATOR . $this->skelDir;

			$tplPHPSrc = $root . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'code.tpl';
			$tplXMLSrc = $root . DIRECTORY_SEPARATOR . 'definition.tpl';

			$phpSrc = $root . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . $args['name'] . '.php';
			$xmlSrc = $root . DIRECTORY_SEPARATOR . $args['name'] . '.xml';

			if (iFile::copyDirectory($skelSrc, $root) === false) return $this->raiseError(null, IERROR_FILE);

			$lifetime = $core->smarty->cache_lifetime;
			$core->smarty->cache_lifetime = 0;
			
			$core->smarty->assign_array($args);
			$xmlContent = $core->smarty->fetch($tplXMLSrc);
			$phpContent = $core->smarty->fetch($tplPHPSrc);
			
			$core->smarty->cache_lifetime = $lifetime;

			if (empty($phpContent) || empty($xmlContent)) return $this->raiseError(null, IERROR_NO_TEMPLATE);

			if (unlink($tplPHPSrc) === false) return $this->raiseError(null, IERROR_FILE_DELETE);
			if (unlink($tplXMLSrc) === false) return $this->raiseError(null, IERROR_FILE_DELETE);
			
			require_once('PHP/Compat.php');

			PHP_Compat::loadFunction('file_put_contents');
			
			if (!file_put_contents($phpSrc, $phpContent)) return $this->raiseError(null, IERROR_FILE_WRITE);
			if (!file_put_contents($xmlSrc, $xmlContent)) return $this->raiseError(null, IERROR_FILE_WRITE);
			
			return true;
		}

		function & onValidate(&$core, &$args)
		{
			$module =& $core->moduleManager->getModule($args['module']);
			if ($this->isError($module)) return printf($module->getMessage());
			if ($module === false) return printf('-1');
			
			$action =& $module->getAction($args['action']);
			if ($this->isError($action)) return printf($action->getMessage());
			if ($action === false) return printf('-1');
			
			unset($args['module'], $args['action']);

			$result =& $core->processParams($action, $args['args']);
			if ($result === true) printf('0');
			else printf("{%s}%s", $action->_lastProcessedArgument, $result->getMessage());
			
			return true;
		}

		function & onCache(&$core, &$args)
		{
			return $core->moduleManager->cache($args['name']);
		}

		function & onCacheAll(&$core, &$args)
		{
			return $core->moduleManager->cacheAll();
		}

		function & onUncache(&$core, &$args)
		{
			return $core->moduleManager->uncache($args['name']);
		}

		function & onUncacheAll(&$core, &$args)
		{
			return $core->moduleManager->uncacheAll();
		}

		function & onClearCache(&$core, &$args)
		{
			global $config;
			
			$module =& $core->moduleManager->getModule($args['module']);
			if ($this->isError($module)) return $module;

			$action =& $module->getAction($args['action']);
			if ($this->isError($action)) return $action;

			$tplMain = $config['dir']['templates'] . DIRECTORY_SEPARATOR . 'xhtml.tpl';
			
			if (!empty($args['all'])) $core->smarty->clear_cache($tplMain);
			else {
				$address = "pages|{$module->name}|{$action->name}";
				if (!empty($args['userid'])) $address .= "|{$args['userid']}";

				$core->smarty->clear_cache(null, $address);
			}
			
			$core->redirect();
			
			return true;
		}

		function & onRegenerate(&$core, &$args)
		{
			$core->moduleManager->removeFromCache($args['module']);
			$core->redirect();
			
			return true;
		}

		function & onClearObservers(&$core, &$args)
		{
			$core->removeAllObservers();
			
			$core->redirect();
			
			return true;
		}
	}

?>
