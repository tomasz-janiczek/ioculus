<?php

	require_once('action.php');

	define('IMOD_SYSTEM',		1);
	define('IMOD_EXTENSION',	2);

	class iModule extends iObject
	{	
		var $name = '';
		var $root = '';

		var $_actions = array();
		
		var $_defaultAction = '';

		var $_source = '';
		var $dbsource = '';
		var $stylesheet = '';
		var $script = '';

		var $phpDir = '';
		var $imageDir = '';
		var $templateDir = '';
		var $templateConfigDir = '';		
		var $styleDir = '';
		var $styleFixDir = '';
		var $scriptDir = '';
		var $uploadDir = '';

		var $type = IMOD_EXTENSION;
		var $description = '';
		var $version = 0;
		
		var $_dbTable = '';
		var $_primaryKey = 'id';
		
		var $paginate = null;

		function __sleep()
		{
			$this->disconnect();
			if (isset($this->_core)) unset($this->_core);

			return array_keys(get_object_vars($this));
		}

		function isConnected()
		{
			$this->_core->log("isConnected - This class: " . get_class($this) . " DB class: " . (isset($this->db) ? get_class($this->db) : 'none'));
			if (!isset($this->db) || !$this->db) return false;
			else return true;
		}

		function disconnect()
		{
			if (isset($this->db)) unset($this->db);
		}

		function connect()
		{
			if (!empty($this->db)) $this->disconnect();
			
			$className = 'MDB_QueryTool';
			if (!empty($this->dbsource)) {
				require_once($this->dbsource);

				$newClass = get_class($this) . '_DB';
				if (class_exists($newClass)) $className = $newClass;
			} else {
				require_once('MDB/QueryTool.php');
			}

			$this->db =& new $className($this->_core->db, array(), 2);						
			$this->db->_core =& $this->_core;
			$this->_core->log("Created database object " . get_class($this->db) . " for module {$this->name}");
			
			$this->db->reset();
			$this->db->setTable($this->_dbTable);
		}

		function loadDBClass()
		{
			$className = 'MDB_QueryTool';
			if (!empty($this->dbsource)) {
				require_once($this->dbsource);

				$newClass = get_class($this) . '_DB';
				if (class_exists($newClass)) $className = $newClass;
			} else {
				require_once('MDB/QueryTool.php');
			}

			$this->db =& new $className($this->_core->db, array(), 2);						
			$this->db->_core =& $this->_core;
			$this->_core->log("Created database object " . get_class($this->db) . " for module {$this->name}");
			
			$this->db->reset();
			$this->db->setTable($this->_dbTable);
		}

		function iModule($name)
		{
			parent::iObject();
			
			$this->name = $name;
		}

		function & getCore()
		{
			return $this->_core;
		}

		function & getVFS()
		{
			if ($this->_core === null) return null;
			else return $this->_core->vfs;
		}

		function & getActionList()
		{
			require_once('cache.php');
			
			$cache =& iCache::singleton();
			return $cache->get($this->name . '_actions');
		}		

		function loadAction($name)
		{
			require_once('cache.php');
			
			$cache =& iCache::singleton();
			if ($cache->isCached($name, $this->name)) $action =& $cache->get($name, $this->name);			
			else return $this->raiseError("Could not load action {$name}");
			
			return $this->registerAction($action);
		}

		function actionIsLoaded($name)
		{
			$name = strtolower($name);
			return isset($this->_actions[$name]);
		}

		function & getAction($name)
		{
			if (!is_string($name) || empty($name)) return $this->raiseError(null, IERROR_PARAMS);
			
			$name = strtolower($name);
			
			if (!$this->actionIsLoaded($name)) {
				$result = $this->loadAction($name);
				if ($this->isError($result)) return $result;
			}
			return $this->_actions[$name];
		}

		function registerAction(&$action)
		{
			if (!is_object($action) || !is_a($action, 'iAction')) return $this->raiseError(null, IERROR_PARAMS);

			$action->name = strtolower($action->name);			
			if (isset($this->_actions[$action->name])) return $this->raiseError(null, IERROR_ACT_EXISTS);		
			else $this->_actions[$action->name] =& $action;

			return true;
		}

		function uncacheAction($name)
		{
			require_once('cache.php');
			
			$cache =& iCache::singleton();
			if ($cache->isCached($name, $this->name)) $cache->remove($name, $this->name);
		}

		function uncacheAllActions()
		{
			$actions =& $this->getActionList();
			foreach ($actions as $action) $this->uncacheAction($action);
		}

		function loadDefinitionFile()
		{
			$xmlPath = $this->_root . DIRECTORY_SEPARATOR . $this->name . '.xml';

			require_once('xml.php');

			$parser =& iXMLModuleParser::singleton();
			$result =& $parser->load($xmlPath, array('module' => &$this));
			if ($this->isError($result)) return $result;
			
			return true;
		}
		
		function raiseError($message, $code = null, $url = null)
		{
			$params = array('url' => !empty($url) ? $url : iCore::URL($this->name, $this->_defaultAction));
			
			return parent::raiseError($message, $code, null, null, $params);
		}
		
		function call($module, $action, $args = array())
		{		
			$module =& $this->getModule($module);
			if ($this->isError($module)) return $module;
			
			$method = 'on' . $action;
			if (!method_exists($module, $method)) return $this->raiseError(null, IERROR_UNSUPPORTED);
			
			if (isset($module->db)) {
				$module->db->reset();
				$module->db->setTable($module->_dbTable);
			}
			
			$result = $module->$method($this->_core, $args);
			if ($this->isError($result)) return $this->raiseError($result);
			else return $result;
		}

		function & getModule($module)
		{
			$module = strtolower($module);
			if ($module === $this->name) {
				if (isset($this->_parent)) return $this->_parent;
				else return $this;
			}
			
			if (!$this->isLoaded($module)) {
				$result = $this->loadModule($module);
				if ($this->isError($result)) return $result;
			}
			
			return $this->modules[$module];
		}

		function isLoaded($module)
		{
			$module = strtolower($module);
			if ($module === $this->name) return true;	
			if (isset($this->modules) && isset($this->modules[$module])) return true;
			else return false;
		}

		function loadModule($module)
		{
			$module = strtolower($module);
			if ($module === $this->name) return true;	
			if ($this->isLoaded($module)) return true;
			
			if (!isset($this->modules)) $this->modules = array();
			
			$class = (isset($this->_parent) ? get_class($this->_parent) : get_class($this)) . '_' . $module;
			$src = $this->phpDir . DIRECTORY_SEPARATOR . $this->name . '_' . $module . '.php';

			if (!file_exists($src)) return $this->raiseError(null, IERROR_MOD_SOURCE);
		
			include_once($src);
			if (!class_exists($class)) return $this->raiseError(null, IERROR_MOD_CLASS);
			
			$this->modules[$module] =& new $class($this->name);

			$mod =& $this->modules[$module];

			// We set this to allow the newly loaded module to load other modules by his own.
			// Other variables must be fetched manually by accessing $this->_parent
			$mod->phpDir = $this->phpDir;
			$mod->_parent =& $this;
			$mod->_core =& $this->_core;
			$mod->modules =& $this->modules;
			if (isset($this->db) && !empty($this->db)) $mod->db =& $this->db;
			if (isset($this->paginate)) $mod->paginate =& $this->paginate;

			$mod->setErrorHandling(PEAR_ERROR_RETURN);			
			
			return true;
		}
	}

	class iModuleDB extends iModule
	{
		var $explicitDelete = false;
		
		function & onAdd(&$core, &$args)
		{
			if (empty($this->db)) return true;
			if (!empty($args[$this->_primaryKey])) return $this->raiseError(null, IERROR_PARAMS);
			
			$this->db->reset();
			$this->db->setTable($this->_dbTable);
			$id = $this->db->add($args);
			if ($id === false) return $this->raiseError(null, IERROR_DB_INSERT);
		
			return $id;
		}

		function & onEdit(&$core, &$args)
		{
			if (empty($this->db)) return true;
			if (empty($args[$this->_primaryKey])) return $this->raiseError(null, IERROR_PARAMS);
			
			$this->db->reset();
			$this->db->setTable($this->_dbTable);
			$result = $this->db->update($args);
			if ($result === false) return $this->raiseError(null, IERROR_DB_UPDATE);
		
			return true;
		}

		function & onDeleteSingle(&$core, &$args)
		{
			if (empty($this->db)) return true;
			if (empty($args[$this->_primaryKey])) return $this->raiseError(null, IERROR_PARAMS);
			
			$this->db->reset();
			$this->db->setTable($this->_dbTable);
			$result = $this->db->remove($args[$this->_primaryKey], $this->_primaryKey);
			if ($result === false) return $this->raiseError(null, IERROR_DB_DELETE);

			return true;
		}

		function & onDelete(&$core, &$args)
		{
			if (empty($this->db)) return true;
			if (empty($args[$this->_primaryKey])) return $this->raiseError(null, IERROR_PARAMS);

			if (!strpos($args[$this->_primaryKey], ',')) {
				$result =& $this->onDeleteSingle($core, $args);
				if ($this->isError($result)) return $result;
			} else {
				$idList = explode(',', $args[$this->_primaryKey]);
				if (empty($idList)) return $this->raiseError(null, IERROR_PARAMS);

				if (!$this->explicitDelete) {
					foreach ($idList as $id) {
						$params = $args;
						unset($params[$this->_primaryKey]);
						$params[$this->_primaryKey] = $id;
						$result = $this->onDeleteSingle($core, $params);
						if ($this->isError($result)) return $result;
					}
				} else {
					$this->db->reset();
					$this->db->setTable($this->_dbTable);
					$result = $this->db->removeMultiple($idList, $this->_primaryKey);
					if ($result === false) return $this->raiseError(null, IERROR_DB_DELETE);
				}
			}
		
			return true;
		}
		
		function & onExists(&$core, &$args)
		{
			if (empty($this->db)) return false;
			if (empty($args[$this->_primaryKey])) return false;

			$this->db->reset();
			$this->db->setTable($this->_dbTable);
			if (is_numeric($args[$this->_primaryKey])) $this->db->setWhere("{$this->_primaryKey} = {$args[$this->_primaryKey]}");
			else if (is_string($args[$this->_primaryKey])) $this->db->setWhere("name = '{$args[$this->_primaryKey]}'");
			else return false;
			
			$result =& $this->db->getAll();
			if ($result === false || empty($result)) return false;
			if (!empty($args['all']) && $args['all'] === true) return $result[0];
			else return $result[0][$this->_primaryKey];
		}
		
		function & onGet(&$core, &$args)
		{
			$this->db->reset();
			$this->db->setTable($this->_dbTable);
			
			$id = $args['id'];
			$all = !empty($args['all']) ? $args['all'] : true;
			
			if (is_numeric($id)) $this->db->setWhere("{$this->_primaryKey} = {$id}");
			else if (is_string($id)) $this->db->setWhere("name = '{$id}'");
			else if (is_array($id) && is_numeric($id[0])) $this->db->setWhere("{$this->_primaryKey} IN (" . implode(',', $id) . ")");
			else if (is_array($id) && is_string($id[0])) {
				foreach ($id as $key => $val) $id[$key] = "'{$val}'";
				$this->db->setWhere("name IN (" . implode(',', $id) . ")");
			}
			else return $this->raiseError(null, IERROR_PARAMS);
			
			$article =& $this->db->getAll();
			if ($article === false || empty($article)) return $this->raiseError(null, IERROR_NOT_FOUND);

			if ($all && is_array($id)) return $article;
			else if ($all) return $article[0];
			else return $article[0][$this->_primaryKey];
		}

		function & onCount(&$core, &$args)
		{
			$this->db->reset();
			$this->db->setTable($this->_dbTable);

			$this->db->setSelect('COUNT(*) AS count');
			if (!empty($args['filters'])) $this->db->setWhere($args['filters']);
			
			$result =& $this->db->getAll();
			if (empty($result) || $result === false) return $this->raiseError(null, IERROR_DB_QUERY);
			
			return $result[0]['count'];
		}
	}

	class iModuleManager extends iObject
	{
		var $_core = null;
		
		var $_modules = array();
		var $_loading = array();
		var $_defaultModule = '';

		var $_loadMethodName = '_onLoad';
		var $_unloadMethodName = '_onUnload';
		var $_executeMethodName = '_onExecute';
		var $_factoryMethodName = 'factory';

		function & factory(&$core)
		{
			$obj =& new iModuleManager($core);
			return $obj;
		}

		function iModuleManager(&$core)
		{
			parent::iObject();
			$this->_core =& $core;
		}

		function registerModule(&$module)
		{
			if (!is_object($module)) return $this->raiseError(null, IERROR_PARAMS);
			if (empty($module->name)) return $this->raiseError(null, IERROR_PARAMS);

			$module->name = strtolower($module->name);			
			if (isset($this->_modules[$module->name])) return $this->raiseError(null, IERROR_MOD_EXISTS);		
			else $this->_modules[$module->name] =& $module;

			return true;
		}

		function unregisterModule($name)
		{
			if (!is_string($name) || empty($name)) return $this->raiseError(null, IERROR_PARAMS);

			$name = strtolower($name);
			if (!isset($this->_modules[$name])) return $this->raiseError(null, IERROR_MOD_NOT_FOUND);
			unset($this->_modules[$name]);
			iObject::reindexArray($this->_modules);
			
			return true;
		}

		function unregisterAllModules()
		{
			unset($this->_modules);
			$this->_modules = array();

			return true;
		}

        function & getModuleDefinitionParser()
		{
			if (empty($this->_modules)) return null;
            return $this->_modules[0]->_parser;
		}												

		function & getModuleList($extended = false)
		{
			global $config;
			
			$result =& iFile::getDirectoryList($config['dir']['modules']);
			
			if ($extended) {
				$list = array();
				foreach ($result as $key => $val) $list[$val] = $config['dir']['modules'] . DIRECTORY_SEPARATOR . $val;
				return $list;
			} else return $result;
		}

		function & getCachedModules()
		{
			$list =& $this->getModuleList();
			
			require_once('cache.php');

			$cache =& iCache::singleton();
			$cachedMods = array();
			
			foreach ($list as $modname)
				if ($cache->isCached($modname)) $cachedMods[] = $modname;
				
			return $cachedMods;
		}
		
		function & getModule($name)
		{
			if (!is_string($name) || empty($name)) return $this->raiseError(null, IERROR_PARAMS);
			
			$name = strtolower($name);
			
			if (!$this->isLoaded($name)) {
				$result = $this->loadModule($name);
				if ($this->isError($result)) return $result;
			}
			
			return $this->_modules[$name];
		}
		
		function isLoaded($moduleName)
		{
			$moduleName = strtolower($moduleName);
			return isset($this->_modules[$moduleName]);
		}
		
		function loadModules($list)
		{
			foreach ($list as $name) {
				$name = strtolower($name);
				if ($this->isLoaded($name)) continue;
				$result = $this->loadModule($name);
				if ($this->isError($result)) return $result;
			}			

			return true;
		}
		
		function & factoryModule($class, $name)
		{
			if (!is_string($class) || !is_string($name) || empty($class) || empty($name))
				return $this->raiseError(null, IERROR_PARAMS);

			$obj =& new $class($name);
			return $obj;
		}
		
		function loadModule($moduleName)
		{
			global $config;
			
			if (!is_string($moduleName) || empty($moduleName)) return $this->raiseError(null, IERROR_PARAMS);

			if (isset($this->_loading[$moduleName]))
				return $this->raiseError("Detected endless loop - module {$moduleName} is already being loaded!");

			// Mark this module as being loaded (avoid endless loop)
			$this->_loading[$moduleName] = true;

			$core =& $this->_core;

			$moduleClass = 'iModule_' . $moduleName;			
			$moduleDir = $config['dir']['modules'] . DIRECTORY_SEPARATOR . $moduleName;
			$phpDir = $moduleDir . DIRECTORY_SEPARATOR . 'php';
			$phpSrc = $phpDir . DIRECTORY_SEPARATOR . $moduleName . '.php';
			
			if (!file_exists($moduleDir)) {
				unset($this->_loading[$moduleName]);
				return $this->raiseError(null, IERROR_MOD_NOT_FOUND);
			}
			if (!file_exists($phpSrc)) {
				unset($this->_loading[$moduleName]);
				return $this->raiseError(null, IERROR_MOD_SOURCE);
			}

			require_once($phpSrc);
			
			if (!class_exists($moduleClass) || !is_callable(array($moduleClass, $moduleClass))) {
				unset($this->_loading[$moduleName]);
				return $this->raiseError(null, IERROR_MOD_CLASS);
			}
			
			/* Should we post a 'moduleLoaded' message?
			 * Yes, if the module is being parsed for the first time (it doesn't come from the cache).
			 * No, if it is in the cache.
			 */
			$notify = false;
			
			require_once('cache.php');
			
			$cache =& iCache::singleton();
			
			if ($cache->isCached($moduleName)) {
				$module =& $cache->get($moduleName);
				$core->log("Restored module {$moduleName} from cache as class " . get_class($module));

				$module->_core =& $core;
			} else {
				$module =& $this->factoryModule($moduleClass, $moduleName);
				if (is_null($module) || !is_object($module) || !is_a($module, 'iModule')) {
					unset($module);
					return $this->raiseError(null, IERROR_MOD_DESCENDANT);
				}

				$module->_root = $moduleDir;
				$module->phpDir = $phpDir;

				$module->imageDir = $module->_root . DIRECTORY_SEPARATOR . 'images';
				$module->templateDir = $module->_root . DIRECTORY_SEPARATOR . 'templates';
				$module->templateConfigDir = $module->templateDir;
				$module->styleDir = $module->_root . DIRECTORY_SEPARATOR . 'styles';
				$module->scriptDir = $module->_root . DIRECTORY_SEPARATOR . 'javascript';
				$module->uploadDir = $module->_root . DIRECTORY_SEPARATOR . 'upload';
							
				$module->stylesheet = $module->styleDir . DIRECTORY_SEPARATOR . $moduleName . '.css';
				if (!file_exists($module->stylesheet)) $module->stylesheet = '';
				$module->script = $module->scriptDir . DIRECTORY_SEPARATOR . $moduleName . '.js';
				if (!file_exists($module->script)) $module->script = '';
				$module->_source = $phpSrc;
				$module->dbsource = $module->phpDir . DIRECTORY_SEPARATOR . $moduleName . '_db.php';
				if (!file_exists($module->dbsource)) $module->dbsource = '';

				$module->_core =& $core;
				
				$result = $module->loadDefinitionFile();
				if ($this->isError($result)) {
					unset($this->_loading[$moduleName]);
					unset($module);
					return $result;
				}

				if (empty($module->_actions)) {
					unset($this->_loading[$moduleName]);
					unset($module);
					return $this->raiseError(null, IERROR_MOD_NO_ACTIONS);
				}

				if (empty($module->_defaultAction)) {				
					$act =& array_pop(array_reverse($module->_actions, true));
					$module->_defaultAction = $act->name;
				}
				
				$actions =& $module->_actions;
				unset($module->_actions);
				$module->_actions = array();
				
				// Cache the module object (but not the actions!)

				$cache->save($module, $module->name);
				$module =& $cache->get($module->name);
				$module->_core =& $core;
				
				// Cache all the action objects of this module in separate files, so they can be loaded one at a time if needed
				foreach ($actions as $key => $val) {
					$cache->save($actions[$key], $actions[$key]->name, $module->name);
				}

				// Cache the actions names
				$actionNames = array();
				foreach ($actions as $key => $val) $actionNames[] = $actions[$key]->name;
				$cache->save($actionNames, $module->name . '_actions');

				unset($actions);

				if (!empty($this->_loadMethodName) && method_exists($module, $this->_loadMethodName)) {
					$method = $this->_loadMethodName;
					$result = $module->$method($core, $args = array());
					if ($this->isError($result)) return $result;
				}

				$notify = true;
			}

			$result = $this->registerModule($module);
			if ($this->isError($result)) {
				unset($this->_loading[$moduleName]);
				unset($module);
				return $result;
			}

			unset($this->_loading[$moduleName]);

			if ($notify) {
				// Disable database query rights filters (module must have full access to database at this moment)
				$state = $core->_filterQueries;
				$core->_filterQueries = false;

				$core->post('core', 'moduleLoaded', array('module' => $module->name));

				// Enable database query rights filters
				$core->_filterQueries = $state;
			}

			return true;
		}
		
		function unloadModule($name)
		{
			return $this->unregisterModule($name);
		}

		function cache($name)
		{
			require_once('cache.php');

			$cache =& iCache::singleton();
			if (!$cache->isCached($name)) return $this->loadModule($name);
			else return true;
		}

		function cacheAll()
		{
			$modules =& $this->getModuleList();
			if ($this->isError($modules)) return $modules;
		
			foreach ($modules as $module) $this->cache($module);
			
			return true;
		}

		function uncache($name)
		{
			require_once('cache.php');
			
			$cache =& iCache::singleton();
			if ($cache->isCached($name)) {
				$module =& $this->getModule($name);
				if ($this->isError($module)) return $module;
				
				$module->uncacheAllActions();
				$cache->remove($module->name . '_actions');							
				$cache->remove($name);
			}
			
			return true;
		}

		function uncacheAll()
		{
			$modules =& $this->getModuleList();
			if ($this->isError($modules)) return $modules;
		
			foreach ($modules as $module) $this->uncache($module);
			
			return true;
		}
	}

?>
