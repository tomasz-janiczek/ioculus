<?php

	require_once('object.php');
	require_once('error.php');
	require_once('Var_Dump.php');

	class iCore extends iObject
	{
		var $_root = '';
		var $_www = '';

		var $smarty = null;
		var $moduleManager = null;
		var $schemeManager = null;
		var $db = null;
		var $menu = null;
		var $user = null;
		var $userAdmin = null;
		var $vfs = null;
		var $document = null;

		/* This controls (globally) wherever the class iModule_DB should perform query filtering based on the rights of the current
		 * user. Set it to false to disable query filtering in ALL iModule_DB objects. !FIXME!
		 */		
		var $_filterQueries = true;
		var $checkRights = true;
		var $connectToDatabase = true;

		var $defaultModule = 'news';

		// This contains: the module being currently run, its action, and the URI md5 hash.
		var $module = '';
		var $action = '';
		var $URIHash = '';

		// Smarty cache 'address' used for the current module, action, user id and URI hash combination.
		var $cacheAddress = '';

		function & factory()
		{
			$obj =& new iCore();
			return $obj;
		}

		function connect()
		{
			global $config;

			$this->disconnect();

			require_once('MDB2.php');
			
			$this->db =& MDB2::singleton($config['dsn'], array('persistent' => true));
			if (MDB2::isError($this->db)) die($this->db->getMessage());
			
			$this->db->loadModule('Extended');
			$this->db->setOption('portability', MDB2_PORTABILITY_ALL ^ MDB2_PORTABILITY_EMPTY_TO_NULL);
		}
		
		function disconnect()
		{
			if (empty($this->db)) return;
			$this->db->disconnect();
			unset($this->db);
		}

		function isConnected()
		{
			if (!isset($this->db) || !$this->db) return false;
			else return true;
		}

		function userConnect()
		{
			if ($this->user) return;
			if (!$this->isConnected()) $this->connect();
			
			require_once('userfactory.php');
			$this->user =& iUserFactory::factory('user', $this->db);
		}

		function userAdminConnect()
		{
			if ($this->userAdmin) return;			
			if (!$this->isConnected()) $this->connect();

			require_once('userfactory.php');
			$this->userAdmin =& iUserFactory::factory('admin', $this->db);			
		}

		function getCacheAddress($module, $action, $userId = null, $cacheId = null)
		{
			if (empty($userId)) {
				if (isset($this->user) && $this->user->isLoggedIn()) $userId = $this->user->getProperty('perm_user_id');
				else $userId = 0;
			}
			if (empty($cacheId)) $cacheId = $this->URIHash;
			
			$address = "pages|{$module}|{$action}|{$userId}";
			if (!empty($cacheId)) $address .= "|{$cacheId}";
			
			return $address;
		}
		
		function createURIHash()
		{
			$uri = array();

			parse_str($_SERVER['QUERY_STRING'], $uri);

			if (isset($uri['m'])) {
				$this->module = $uri['m'];
				unset($uri['m']);
			} else {
				$this->module = $this->defaultModule;
			}						

			if (isset($uri['act'])) {
				$this->action = $uri['act'];
				unset($uri['act']);
			} else {
				$mod =& $this->moduleManager->getModule($this->module);
				if ($this->isError($mod)) return $mod;
				$this->action = $mod->_defaultAction;
			}

			if (!empty($uri)) $this->URIHash = md5(implode('', $uri));
		}
		
		function log($message)
		{	
			if (!isset($this->logger)) {
				global $config;
				
				require_once('Log.php');
				
				$conf = array('mode' => 0600, 'timeFormat' => '%X %x');
				$path = $config['root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'system.log';
				$this->logger =& Log::singleton('file', $path, 'ident', $conf);
			}
			$this->logger->log($message);
		}
		
		function iCore()
		{
			global $config;

			parent::iObject();
			
			$this->_root = $config['root'];

			if (!($this->connectToDatabase = !empty($config['dsn']))) $this->checkRights = false;
		
			require_once('file.php');
			
			$this->vfs =& iVFS::factory('file', array('vfsroot' => '/'));

			require_once('templates.php');
	
			$this->smarty =& iSmarty::factory($config['dir']['smarty']);
			$this->smarty->core =& $this;
			$this->smarty->registerPlugins($this);

			$this->schemeManager =& iSmarty_SchemeManager::factory($config['dir']['schemes']);

			require_once('menu.php');
			$this->menu =& iMenu::factory();
			
			require_once('module.php');

			$this->moduleManager =& iModuleManager::factory($this);

			require_once('document.php');
			
			$this->document =& iDocument::factory();
			if (!empty($conf['document']['title'])) $this->document->title = $conf['document']['title'];
			if (!empty($conf['document']['charset'])) $this->document->charset = $conf['document']['charset'];
			if (!empty($conf['document']['doctype'])) $this->document->charset = $conf['document']['doctype'];
			
			if ($this->connectToDatabase) {
				$this->userConnect();	

				if (!$this->user->init()) {
				    echo 'cannot initialize liveuser, show the reason(s)';
				    var_dump($this->user->getErrors());
				    exit(1);
				}
			}
			
			$result =& $this->createURIHash();
			if ($this->isError($result)) die($this->Error($result->getMessage()));
			
			if ($this->connectToDatabase) {
				if (!$this->user->isLoggedIn()) {
					$this->log("User not logged in, logging in as guest");
					$result = $this->call('user', 'guestlogin');
					if ($this->isError($result)) die('onGuestLogin: ' . $result->getMessage());
				}
			}

			$this->cacheAddress =& $this->getCacheAddress($this->module, $this->action);
			if ($this->isError($result)) die($this->Error($result->getMessage()));
			
		}

		function processParams(&$action, &$args)
		{
			if (!is_object($action) || !is_array($args)) return $this->raiseError(null, IERROR_PARAMS);

			foreach ($action->params as $param) {
				$action->_lastProcessedArgument = $param->name;
				switch ($param->type)
				{
				case IPARAM_FILE:
					switch ($param->required)
					{
					case false:
					default:
						if ($_FILES[$param->name]['size'] == 0) break;
					
					case true:
						if ($_FILES[$param->name]['size'] == 0 ||
						    ($_FILES[$param->name]['size'] != 0 && $_FILES[$param->name]['error'] != UPLOAD_ERR_OK)) {
							return $this->raiseError('Parametr <b>' . $param->name . '</b> (plik) jest wymagany, lecz nie został podany');
						}
						
						// Check file size
						if (!empty($param->requiredSize)) {
							if ($_FILES[$param->name]['size'] != $param->requiredSize)
								return $this->raiseError('Parametr <b>' . $param->name . '</b> posiada niepoprawny rozmiar');
						} else {
							if (!empty($param->minSize) && $_FILES[$param->name]['size'] < $param->minSize)
								return $this->raiseError('Parametr <b>' . $param->name . '</b> posiada zbyt mały rozmiar');
							if (!empty($param->maxSize) && $_FILES[$param->name]['size'] > $param->maxSize)
								return $this->raiseError('Parametr <b>' . $param->name . '</b> posiada zbyt duży rozmiar');
						}

						// Check MIME type
						if (!empty($param->mimeTypes)) {
							$allow = false;
							$type = strtolower(strtr($_FILES[$param->name]['type'], ' ', ''));
							foreach ($param->mimeTypes as $allowedType) {
								if ($allowedType === $type) {
									$allow = true;
									break;
								}
							}
							if ($allow === false)
								return $this->raiseError('Parametr <b>' . $param->name . '</b> ma niewłaściwy format');
						}

						// Check extensions
						if (!empty($param->extensions)) {
							$allow = false;
							$info = pathinfo(strtolower($_FILES[$param->name]['name']));
							foreach ($param->extensions as $ext) {
								if ($ext === $info['extension']) {
									$allow = true;
									break;
								}
							}
							if ($allow === false)
								return $this->raiseError('Parametr <b>' . $param->name . '</b> ma niewłaściwy format (rozszerzenie)');
						}

						$args[$param->name] =& $_FILES[$param->name];
						break;
					}				
					break;
					
				case IPARAM_GETPOST:
				default:
					if (empty($args[$param->name]) && $param->required === true) {
						$param->runModifier('default', $args[$param->name]);
						if (!isset($args[$param->name]))
							return $this->raiseError('Parametr <b>' . $param->name . '</b> jest wymagany, lecz nie został podany');
					} else if (empty($args[$param->name]) && $param->required === false) {
						unset($args[$param->name]);
					}
					break;
				}
			}

			foreach ($args as $name => $value) {
				$param =& $action->getParam($name);
				if ($this->isError($param)) {
					unset($args[$name]);
					continue;
				}

				$action->_lastProcessedArgument = $param->name;
				if ($param->type === IPARAM_FILE) continue;
				
				$param->runModifiers($args[$name]);

				$result =& $param->runValidators($args[$name]);
				if (is_array($result)) {
					if (!empty($result['params']['_errorText'])) $errorText = $result['params']['_errorText'];
					else {
						$errorText = 'Parametr <b>' . $name . '</b> jest niepoprawny!<br/><br/>' .
								    '<b>Akcja:</b> ' . $action->name . '<br/>' .
								    '<b>Wartość:</b> ' . (is_numeric($args[$name]) ? $args[$name] : '[tekst]') . '<br/>' .
								    '<b>Kryterium:</b><i> ' . $result['name'] . '</i><br/>';
					}

					return $this->raiseError($errorText);
				}
			}
			
			return true;
		}

		function getRightId($module, $action = '')
		{
			if (!is_string($module) || !is_string($action)) return $this->raiseError(null, IERROR_PARAMS);
			if (empty($this->user->_rightList)) return $this->raiseError(null, IERROR_NOT_FOUND);
			
			if (empty($action)) $rightName = sprintf("%s_*", $module);
			else $rightName = sprintf("%s_%s", $module, $action);
			
			if (isset($this->user->_rightList[$rightName])) return $this->user->_rightList[$rightName];
			else return $this->raiseError(null, IERROR_NOT_FOUND);
		}

		function checkRightByName($module, $action = '')
		{
			if ($this->user->getProperty('perm_type') == LIVEUSER_MASTERADMIN_TYPE_ID) return true;
		
			$rightId = $this->getRightId($module, $action);
			if ($this->isError($rightId)) return false;
			
			return $this->user->checkRight($rightId);
		}

		function doRedirect($mode)
		{
			switch (strtolower($mode))
			{
			case 'empty':
			case 'raw':
				$mode = 'xhtml';

			case 'xhtml':
			default:
				$doRedirect = true;
				break;

			case 'xml':
			case 'ajax':
				$doRedirect = false;
				break;
			}
			
			return $doRedirect;
		}

		function & moduleExecute(&$module, &$action, &$args, $checkRights = true, $coreCall = false)
		{
			if (!is_object($module) || !is_object($action) || !is_array($args)) return $this->raiseError(null, IERROR_PARAMS);
			
			$this->log("Executing module {$module->name}, action {$action->name}");
			
			$handler = $action->getHandler();
			if ($this->isError($handler)) return $handler;
			
			if (empty($handler) || !method_exists($module, $handler)) return true;

			/*
			 * If this isn't a core call (the module was executed by a HTTP query and is the first one called in the whole
			 * execution chain), clear all Smarty variables, including the template configs
			 */
			if (!$coreCall) {
				$this->smarty->clear_config();
				$this->smarty->clear_all_assign();
			} else $this->coreCall = true;
	
			// The above line makes it possible for a module to determine, if it was called from 'outside', or from 'inside' the core
	
			// Check, if this module needs database access. If so, check if its QueryTool object was created. If not - create one.
			// FIXME! Creates the object always and for all the actions, but should only do it for the specified ones.
			if ($this->connectToDatabase && !$module->isConnected()) {
				$this->log("Connecting module {$module->name} database object");
				$module->connect();
			} else {
				$this->log("No need to connect module {$module->name} database object - already connected");
			}
			
			if ($this->connectToDatabase && !isset($this->userAdmin)) $this->userAdminConnect();

			if (!empty($this->moduleManager->_executeMethodName) && method_exists($module, $this->moduleManager->_executeMethodName)) {
				$method = $this->moduleManager->_executeMethodName;
				$result = $module->$method($this, $args = array('module' => &$module, 'action' => &$action, 'args' => &$args));
				if ($this->isError($result)) return $result;
			}

			// Change the names of the action parameters (array keys) to lower case, and process them (modify and validate).
			$actionArgs = array_change_key_case($args, CASE_LOWER);
			$result =& $this->processParams($action, $actionArgs);			
			if ($this->isError($result)) return $result;			
			
			/* [ Automatic pagination ]
			 * If the action has a registered iActionPagination object, do all the dirty work around assigning the id, url etc.
			 * Then the only thing left for the action handler to do (if any) is to, optionally, set the current total item count.
			 */
			if (!empty($action->paginate)) {					
				$action->paginate->connect();
				$action->paginate->setURL($_SERVER['QUERY_STRING']);
				$module->paginate =& $action->paginate;
			}

			$result =& $module->$handler($this, $actionArgs);
			
			if (isset($this->coreCall)) unset($this->coreCall);

			if (!empty($action->paginate)) $action->paginate->assign($this->smarty);
				
			return $result;
		}

		function & moduleDisplay(&$module, &$action, &$args, $mode = 'xhtml')
		{
			if (!is_object($module) || !is_object($action) || !is_array($args)) return $this->raiseError(null, IERROR_PARAMS);
						
			$template = $action->getTemplate($mode);
			if ($this->isError($template)) return $template;
			if (empty($template)) {
				if ($module->type != IMOD_SYSTEM && $this->doRedirect($mode))
					$this->redirect(iCore::URL($module->name, $module->_defaultAction, array(), 'xhtml', false));

				return false;
			}

			$this->log("{$module->name}:{$action->name} Action template not cached, fetching");
			
			// Let's see, if this template has got an associated config file. If yes - load it.
			
			$templateConfig = $action->getTemplateConfig($mode);
			if ($this->isError($templateConfig)) return $templateConfig;
			if (!empty($templateConfig)) $this->smarty->config_load($templateConfig);

			// Preassign some Smarty variables that could become useful for the webmaster
			
			if ($this->user && $this->user->isLoggedIn() && $this->user->getProperty('handle') != 'Guest') {
				$this->smarty->assign('iUserLoggedIn', true);
				$this->smarty->assign_by_ref('iUser', $this->user);
			} else {
				$this->smarty->assign('iUserLoggedIn', false);
			}

			$script = $action->getScript($mode);
			$style = $action->getStyle($mode);
			
			$this->smarty->assign('iModuleName', $module->name);
			$this->smarty->assign('iActionName', $action->name);
			$this->smarty->assign('iArgs', $args);
			$this->smarty->assign('iActionCSS', iCore::windowsPath(iVFS::relativePathA($style, $this->_root)));
			$this->smarty->assign('iActionJS', iCore::windowsPath(iVFS::relativePathA($script, $this->_root)));
			$this->smarty->assign('iImageDir', iCore::windowsPath(iVFS::relativePathA($module->imageDir, $this->_root)));
			$this->smarty->assign('iUploadDir', iCore::windowsPath(iVFS::relativePathA($module->uploadDir, $this->_root)));
			$this->smarty->assign('iTemplateDir', iCore::windowsPath(iVFS::relativePathA($action->tplDir, $this->_root)));

			if (!empty($module->script)) $this->includeJavascript($module->script);
			if (!empty($module->stylesheet)) $this->includeStylesheet($module->stylesheet);

			if (!empty($script)) $this->includeJavascript($script);
			if (!empty($style)) $this->includeStylesheet($style);
			
			$styleIE = $action->getStyle($mode, 'IE');
			if (!$this->isError($styleIE) && !empty($styleIE)) $this->includeStylesheet($styleIE, 'IE');

			$styleIE = $action->getStyle($mode, 'IE5');
			if (!$this->isError($styleIE) && !empty($styleIE)) $this->includeStylesheet($styleIE, 'IE5');

			$styleIE = $action->getStyle($mode, 'IE6');
			if (!$this->isError($styleIE) && !empty($styleIE)) $this->includeStylesheet($styleIE, 'IE6');

			$this->smarty->cache_lifetime = 0;
			
			$this->log("Generating display output for cache address {$this->cacheAddress}");
			
			return $this->smarty->fetch($template, $this->cacheAddress);
		}

		function & moduleRun($moduleName, $actionName, &$getArray, &$postArray, $mode = 'xhtml', $checkRights = true)
		{
			// Check, if the current user has all the needed rights to access this module and action
			if ($this->checkRights && $checkRights) {
				if (!$this->checkRightByName($moduleName)) {
					if (!$this->checkRightByName($moduleName, $actionName)) {
						$error = $this->raiseError(null, IERROR_ACCESS);
						die($error->getMessage());
					}
				}
	    		}

			$this->log("\n*** {$moduleName}:{$actionName} execution started ***");

			// Choose an error method. We must use raw errors (print()) for system modules etc.
			if (isset($this->_disallowMessages)) $errorMethod = 'debug';
			else $errorMethod = 'Error';

			global $config;

	            	$tplMain = $config['dir']['templates'] . DIRECTORY_SEPARATOR . 'modes' . DIRECTORY_SEPARATOR . $mode . DIRECTORY_SEPARATOR;
			
			if ($mode === 'raw') $tplMain = null;
			else if ($mode === 'empty') $tplMain .= 'empty.tpl';
			else if ($mode === 'ajax') $tplMain .= 'ajax.tpl';
			else if ($mode === 'xml') $tplMain .= 'xml.tpl';
			else $tplMain .= 'xhtml.tpl';
			
			// Find the specified module (and load it, if it wasn't used yet).
			$module =& $this->moduleManager->getModule($moduleName);
			if ($this->isError($module)) return $this->$errorMethod($module->getMessage());

			if ($module === false) return $this->$errorMethod('Moduł ' . $moduleName . ' nie istnieje');

			// If no action name was given, fire up the default one.
			if (empty($actionName)) $actionName = $module->_defaultAction;

			// Find the specified module action (and load it, if it wasn't used yet).
			$action =& $module->getAction($actionName);
			if ($this->isError($action)) return $this->$errorMethod($action->getMessage());
			if ($action === false) return $this->$errorMethod('Akcja ' . $actionName . ' nie istnieje');

			$args =& array_merge($getArray, $postArray);

			// Update the core module and action names, and generate a new Smarty cache address
			$this->module = $moduleName;
			$this->action = $actionName;
			$this->URIHash = md5(implode('', $args));
			$this->cacheAddress = $this->getCacheAddress($moduleName, $actionName);

			$handler = $action->getHandler($mode);
			if ($this->isError($handler)) return $handler;

			$tpl = $action->getTemplate($mode);
			if ($this->isError($tpl)) return $tpl;

			if ((($action->cacheLifeTime < 0 || $action->cacheLifeTime > 0) && !$this->smarty->is_cached($tplMain, $this->cacheAddress)) ||
				$action->cacheLifeTime == 0 || (empty($tpl) && method_exists($module, $action->$handler)))
			{
				$this->log("Action template not cached");
				
		                $result = $this->moduleExecute($module, $action, $args, $checkRights);
				if ($this->isError($result)) return $this->$errorMethod($result->getMessage());

				$this->smarty->assign('iDocumentTitle', $this->document->title);
				$this->smarty->assign('iDocumentCharset', $this->document->charset);
				$this->smarty->assign('iDocType', $this->document->doctype);
			
	      			$this->smarty->assign_by_ref('iMenuData', $this->menu->menu);

				$result =& $this->moduleDisplay($module, $action, $args, $mode);
				if ($this->isError($result)) return $this->$errorMethod($result->getMessage());
				$this->smarty->assign_by_ref('iPageContent', $result);
				
				$CSSFiles =& $this->smarty->get_template_vars('iCSSFiles');
		             	if (!empty($CSSFiles)) {
					$CSSFiles = array_reverse($CSSFiles);
					$this->smarty->clear_assign('iCSSFiles');
					$this->smarty->assign_by_ref('iCSSFiles', $CSSFiles);
				}

				$JSFiles =& $this->smarty->get_template_vars('iJSFiles');
				if (!empty($JSFiles)) {
					$JSFiles = array_reverse($JSFiles);
					$this->smarty->clear_assign('iJSFiles');
			        	$this->smarty->assign_by_ref('iJSFiles', $JSFiles);
				}
			} else $this->log("{$module->name}:{$action->name} Action template cached");

			$this->log("\n*** {$module->name}:{$action->name} execution ended ***");

			if (!empty($tpl)) {
				$this->log("Generating main template display output for cache address {$this->cacheAddress}");
				$this->smarty->cache_lifetime = $action->cacheLifeTime;
				return $this->smarty->fetch($tplMain, $this->cacheAddress);
			} else if ($this->doRedirect($mode)) {
				$this->redirect($this->URL($module->name, $module->_defaultAction, array(), $mode, false));
				return '';
			} else return $this->smarty->get_template_vars('iPageContent');
		}

		function URL($module, $action = '', $args = array(), $mode = 'xhtml', $encode = true)
		{
			if (!is_string($module) || !is_string($action) || !is_array($args)) return 'error';
		
			$url = '?m=' . $module;
			if (!empty($action)) $url .= '&act=' . $action;
			if (empty($mode)) $mode = 'xhtml';
			if (strtolower($mode) != 'xhtml') $url .= '&mode=' . $mode;
			if (!empty($args)) {
				foreach ($args as $key => $value) {
					$url .= '&' . $key . '=' . urlencode($value);
				}
			}
			if ($encode) $url = htmlspecialchars($url);
			
			return $url;
		}

		function defaultURL($encode = true)
		{
			return $this->URL($this->defaultModule, '', array(), 'xhtml', $encode);
		}

		function & call($moduleName, $actionName, $args = array())
		{
			global $config;
					
			if (!is_string($moduleName) || !is_string($actionName) || !is_array($args)) return $this->raiseError(null, IERROR_PARAMS);

			$module =& $this->moduleManager->getModule($moduleName);
			if ($this->isError($module)) return $module;
			if ($module === false) return $this->raiseError('Moduł ' . $moduleName . ' nie istnieje');

			$action =& $module->getAction($actionName);
			if ($this->isError($action)) return $action;
			if ($action === false) return $this->raiseError('Akcja ' . $actionName . ' nie istnieje');

			$result =& $this->moduleExecute($module, $action, $args, false, true);
			
			return $result;
		}

		function & run($module, $action, $args = array())
		{
			if (!is_string($module) || !is_string($action) || !is_array($args)) return $this->raiseError(null, IERROR_PARAMS);

			return $this->moduleRun($module, $action, $args, $post = array(), 'xhtml', false);
		}

		function debug($message)
		{
			die($message);
		}

		function & _systemMessage($type, $message, $url = null, $title = 'Błąd')
		{
			$this->_disallowMessages = true;
			
			$params = array('msg' => $message);
			if (!empty($url)) $params['url'] = $url;
			if (!empty($title)) $params['title'] = $title;			

			$content =& $this->run('sysmsg', $type, $params);

			unset($this->_disallowMessages);
			
			return $content;
		}
		
		function & Error($message, $url = null, $title = 'Błąd')
		{
			return $this->_systemMessage('error', $message, $url, $title);
		}

		function & Message($message, $url = null, $title = 'Wiadomość')
		{
			return $this->_systemMessage('info', $message, $url, $title);
		}
		
		function redirect($url = null)
		{
			require_once('HTTP.php');
			
			if (empty($url)) $url = $this->defaultURL();
			HTTP::redirect($url);
		}

		/* Redirects an logical (and ONLY logical) action to a given URL/module/action.
		 * Logical actions do not have a visual representation, thus when called from outside the core, they must be redirected to an visual action after
		 * their code has been executed. If this is not done, the user will see a empty page.
		 */
		function returnTo($url)
		{
			// When inside a "core call", we do not make any redirects.
			if (isset($this->coreCall)) return;
			
			$this->redirect($url);
		}

		function windowsPath($string)
		{
			global $config;
			
			if ($config['os'] == 'win') return str_replace(DIRECTORY_SEPARATOR, "/", $string);
			else return $string;
		}

		function includeStylesheet($path, $browser = 'all')
		{
			$varName = '';
			
			switch (strtoupper($browser)) {
				case 'IE':
					$varName = 'iCSSFiles_IE';
					break;

				case 'IE5':
					$varName = 'iCSSFiles_IE5';
					break;

				case 'IE6':
					$varName = 'iCSSFiles_IE6';
					break;

				case 'all':
				default:
					$varName = 'iCSSFiles';
					break;
			}
			
			$relativeCSS = iVFS::relativePathA($path, $this->_root);
			$relativeCSS = iCore::windowsPath($relativeCSS);
			$css =& $this->smarty->get_template_vars($varName);
			if (empty($css) || !in_array($relativeCSS, $css)) $this->smarty->append($varName, $relativeCSS);

			return true;
		}		

		function includeJavascript($path)
		{
			$relativeJS = iVFS::relativePathA($path, $this->_root);
			$relativeJS = iCore::windowsPath($relativeJS);
			$js =& $this->smarty->get_template_vars('iJSFiles');
			if (empty($js) || !in_array($relativeJS, $js)) $this->smarty->append('iJSFiles', $relativeJS);
				
			return true;
		}
		
		function & getModuleDatabase($module)
		{
			$mod =& $this->moduleManager->getModule($module);
			if ($this->isError($mod)) return $mod;

			if (!$mod->isConnected()) $mod->connect();
			
			return $mod->db;
		}
		
		function post($module, $event, $args = array())
		{
			if (!is_string($module) || !is_string($event)) return $this->raiseError(null, IERROR_PARAMS);

			$callbacks =& $this->getObservers($module, $event);
			if ($this->isError($callbacks)) return $callbacks;
			if (empty($callbacks)) return true;

			foreach ($callbacks as $callback) {
				$mod =& $this->moduleManager->getModule($callback[0]);
				if ($this->isError($mod)) return $mod;

				$action = $callback[1];
				
				$result =& $this->call($mod->name, $action, $args);
				if ($this->isError($result)) return $result;
			}
			
			return true;
		}

		function & getObservers($module, $event, $callback = array())
		{
			if (!is_string($module) || !is_string($event)) return $this->raiseError(null, IERROR_PARAMS);

			if (!isset($this->events)) {
				require_once('cache.php');
				
				$cache =& iCache::singleton();
				$this->events =& $cache->get('events', 'core');
			}
			
			if ($this->events === null || !isset($this->events[$module]) || !isset($this->events[$module][$event]))
				return array();

			if (empty($callback)) return $this->events[$module][$event];

			foreach ($this->events[$module][$event] as $val) {
				if ($val[0] == $callback[0] && $val[1] == $callback[1]) return $callback;
			}
			
			return $this->raiseError(null, IERROR_NOT_FOUND);
		}
		
		function addObserver($module, $event, $callback)
		{
			if (!is_string($module) || !is_string($event) || !is_array($callback)) return $this->raiseError(null, IERROR_PARAMS);

			if (!isset($this->events)) {
				require_once('cache.php');
				
				$cache =& iCache::singleton();
				$this->events =& $cache->get('events', 'core');
			}

			if ($this->events === null) $this->events = array();
			
			if (!isset($this->events[$module])) $this->events[$module] = array();
			if (!isset($this->events[$module][$event])) $this->events[$module][$event] = array();

			// Check, if such a callback already exists. If so, do not add another one, just return with success.
			foreach ($this->events[$module][$event] as $val) {
				if ($val[0] == $callback[0] && $val[1] == $callback[1]) return true;
			}
			
			$this->events[$module][$event][] = $callback;

			require_once('cache.php');
				
			$cache =& iCache::singleton();
			$cache->save($this->events, 'events', 'core');
						
			return true;
		}

		function removeObserver($module, $event, $callback)
		{
			if (!is_string($module) || !is_string($event) || !is_array($callback)) return $this->raiseError(null, IERROR_PARAMS);

			if (!isset($this->events)) {
				require_once('cache.php');
				
				$cache =& iCache::singleton();
				$this->events =& $cache->get('events', 'core');
			}

			if ($this->events === null || empty($this->events) || !isset($this->events[$module]) ||
				!isset($this->events[$module][$event])) return $this->raiseError(null, IERROR_NOT_FOUND);
			
			// Check, if such a callback already exists. If so, do not add another one, just return with success.
			foreach ($this->events[$module][$event] as $key => $val) {
				if ($val[0] == $callback[0] && $val[1] == $callback[1]) {
					unset($this->events[$module][$event][$key]);
					break;
				}
			}

			require_once('cache.php');
				
			$cache =& iCache::singleton();			
			$cache->save($this->events, 'events', 'core');
			
			return true;
		}		

		function removeAllObservers()
		{
			require_once('cache.php');
			
			$cache =& iCache::singleton();
			$cache->remove('events', 'core');
			if (isset($this->events)) unset($this->events);
			
			return true;
		}
	}

	class iSession
	{	
		function isiset($name)
		{
			if (!isset($_SESSION[ISESSION_NAME]) || 
			    !isset($_SESSION[ISESSION_NAME][$name])) return false;
			else return true;
		}

		function set($name, &$value)
		{
			if (!isset($_SESSION[ISESSION_NAME]))
				$_SESSION[ISESSION_NAME] = array();

			$_SESSION[ISESSION_NAME][$name] =& $value;
		}

		function & get($name)
		{
			if (!iSession::isiset($name)) return null;
			else return $_SESSION[ISESSION_NAME][$name];
		}

		function & getSessionVars($type)
		{
			$names = array_keys($_SESSION);

			switch ($type) {
			case 'string':
			default:
				return implode("\n", $names);
				
			case 'array':
				return $names;
			}
		}
		
		function setupHeaders()
		{
			$now = time();
			
			header('Content-type: text/html; charset=utf-8');
			header('Date: '.gmdate('D, d M Y H:i:s \G\M\T', $now));
			header('Last-Modified: '.gmdate('D, d M Y H:i:s \G\M\T', $now));
		}

		function setupCaching()
		{
			session_cache_limiter('nocache');
		}
		
		function setup()
		{
			iSession::setupCaching();
			iSession::setupHeaders();
		}		

		function & start()
		{
			global $config;
			static $instance = null;

			iSession::setup();

			session_name(ISESSION_NAME);
			session_start();

			if (!$instance) $instance =& iCore::factory();

			return $instance;
		}
	
		function stop()
		{
			global $config;

			require_once('cache.php');

			$core =& iSession::start();
			$core->smarty->clear_all_cache();
			
			$cache =& iCache::factory($config['dir']['cache']);
			$cache->clean();
			
			session_unset();
			session_destroy();
		}
		
		function gzipStart()
		{
			ob_start();
			ob_implicit_flush(0);		
		}		

		function gzipStop()
		{
			global $HTTP_ACCEPT_ENCODING;
		
		    if(headers_sent()) {
		        $encoding = false;
		    } elseif (strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false) {
				$encoding = 'x-gzip';
		    } elseif (strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false) {
		        $encoding = 'gzip';
		    } else {
		        $encoding = false;
		    }

		    if ($encoding) {
		        $contents = ob_get_contents();
		        ob_end_clean();
		        header('Content-Encoding: '.$encoding);
		        print("\x1f\x8b\x08\x00\x00\x00\x00\x00");
		        $size = strlen($contents);
		        $contents = gzcompress($contents, 4);
		        $contents = substr($contents, 0, $size);
		        print($contents);
		        exit();
		    } else {
		        ob_end_flush();
		        exit();
			}
		}
	}

?>
