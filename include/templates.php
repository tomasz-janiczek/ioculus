<?php

	require_once('modulemanager.php');

	class iSmarty_Scheme extends iModuleCommon
	{
		var $header = '';
		var $footer = '';
		var $config = '';
		var $stylesheet = '';
		var $script = '';
		
		var $styleDir = '';
		var $scriptDir = '';
		
		function & factory($name)
		{
			$obj =& new iSmarty_Scheme($name);
			return $obj;
		}		
	}

	class iSmarty_SchemeManager extends iModuleManagerCommon
	{
		var $headerName = 'header.tpl';
		var $footerName = 'footer.tpl';
		var $baseName = 'scheme';
		
		function & factory($rootDir)
		{
			$obj =& new iSmarty_SchemeManager($rootDir);
			return $obj;
		}
				
		function & getScheme($name)
		{
			if (!$this->isLoaded($name)) $this->load($name);
			return $this->get($name);
		}
		
		function & load($name)
		{
			if (!is_string($name) || empty($name)) return $this->raiseError(null, IERROR_PARAMS);

			$scheme =& iSmarty_Scheme::factory($name);

			$scheme->root = $this->root . DIRECTORY_SEPARATOR . $scheme->name;
			$scheme->styleDir = $scheme->root . DIRECTORY_SEPARATOR . 'styles';
			$scheme->scriptDir = $scheme->root . DIRECTORY_SEPARATOR . 'javascript';
			
			$scheme->header = $scheme->root . DIRECTORY_SEPARATOR . $this->headerName;
			if (!file_exists($scheme->header)) $scheme->header = '';
			$scheme->footer = $scheme->root . DIRECTORY_SEPARATOR . $this->footerName;
			if (!file_exists($scheme->footer)) $scheme->footer = '';
			$scheme->config = $scheme->root . DIRECTORY_SEPARATOR . $this->baseName . '.conf';
			if (!file_exists($scheme->config)) $scheme->config = '';
			$scheme->stylesheet = $scheme->styleDir . DIRECTORY_SEPARATOR .  $this->baseName . '.css';
			if (!file_exists($scheme->stylesheet)) $scheme->stylesheet = '';
			$scheme->script = $scheme->scriptDir . DIRECTORY_SEPARATOR . $this->baseName . '.js';
			if (!file_exists($scheme->script)) $scheme->script = '';
		
			return $this->register($scheme);
		}		
	}

	require_once('smarty/Smarty.class.php');

	class iSmarty extends Smarty
	{
		var $root = '';
		var $core = null;
		var $defaultCacheLifeTime = -1;

		function factory($root)
		{
			$obj =& new iSmarty($root);
			return $obj;
		}

		function iSmarty($root)
		{
			global $config;

			parent::Smarty();

			$this->root = $root;

			$this->template_dir = $config['root'];
			$this->compile_dir = $root . DIRECTORY_SEPARATOR . 'templates_c';
			$this->config_dir = $config['root'];
			$this->cache_dir = $root . DIRECTORY_SEPARATOR . 'cache';
			$this->plugins_dir[] = $root . DIRECTORY_SEPARATOR . 'plugins';
			
			$this->defaultCacheLifeTime = -1;
						
			$this->cache_lifetime = $this->defaultCacheLifeTime;
			$this->caching = 2;
		}
		
		function registerPlugins()
		{
			$this->register_block('iScheme', array('iSmarty', 'smarty_block_iScheme'));

			$this->register_function('iURL', array('iSmarty', 'smarty_function_iURL'));			
			$this->register_function('iMenu', array('iSmarty', 'smarty_function_iMenu'));
			$this->register_function('iIncludeCSS', array('iSmarty', 'smarty_function_iIncludeCSS'));
			$this->register_function('iIncludeJS', array('iSmarty', 'smarty_function_iIncludeJS'));
			$this->register_function('iSchemeInclude', array('iSmarty', 'smarty_function_iSchemeInclude'));
			$this->register_function('iIncludeTemplate', array('iSmarty', 'smarty_function_iIncludeTemplate'));
		}		

		function assign_array(&$data, $byRef = false)
		{
			if (!is_array($data)) return true;
			
			if ($byRef) $assignFunction = 'assign_by_ref';
			else $assignFunction = 'assign';
			
			foreach ($data as $key => $value) $this->$assignFunction($key, $data[$key]);
			
			return false;
		}

		function getCacheAddress($scheme, $hash = null)
		{
			if (isset($this->core) && isset($this->core->user) && $this->core->user->isLoggedIn())
				$userId = $this->core->user->getProperty('perm_user_id');
			else $userId = 0;
			
			$address = "schemes|{$scheme}|{$userId}";
			if (!empty($hash)) $address .= "|{$hash}";
			
			return $address;
		}

		function & smarty_function_iURL($params)
		{
			if (!isset($params['module'])) return '';

			$args = $params;
			unset($args['module']);
			unset($args['action']);
			return iCore::URL($params['module'], !empty($params['action']) ? $params['action'] : '', $args);
		}

		function & smarty_function_iMenu_render(&$element)
		{
			$_output = "'" . $element['text'] . "', " . (isset($element['link']) ? ("'" . $element['link'] . "'") : "null");

			if (isset($element['submenu'])) {
				$_output .= ", null,";
			        foreach($element['submenu'] as $_submenu) {
					$_output .=  iSmarty::smarty_function_iMenu_render($_submenu);
				}
			}
			
			return sprintf("[%s],", $_output);
		}

		function & smarty_function_iMenu($params, &$smarty)
		{
			if (empty($params['data'])) {
				$smarty->trigger_error("menu_init: missing 'data' parameter");
				return false;
			}
			
			$_output = '';
			foreach ($params['data'] as $_element) {
//				if (!$this->user->checkRight($_element['text'], 'menu')) continue;
				$_output .=  iSmarty::smarty_function_iMenu_render($_element);
			}

			if (!empty($params['container'])) {
				$_menu_init = "iMenu_init('" . $params['container'] . "');";
			}

			return sprintf('<script language="javascript" type="text/javascript">' . "\nvar MENU_ITEMS = [\n%s\n];\n%s\n</script>", $_output,
					     $_menu_init);
		}

		function & smarty_block_iScheme($params, $content, &$smarty, &$repeat)
		{
			if ($repeat) return;
			
			$core =& $smarty->core;
		
			$name = $params['name'];
			unset($params['name']);

			$display = !empty($params['display']) ? strtolower($params['display']) : 'all';
			unset($params['display']);

			$scheme =& $core->schemeManager->getScheme($name);
			if ($core->schemeManager->isError($scheme))
				return ('Scheme <b>' . $name . '</b> error: ' . $scheme->getMessage() . '<br/>');
			if ($scheme === false)
				return ('Scheme <b>' . $name . '</b> not found<br/>');

			$body = '';

			if ($scheme->stylesheet) $core->includeStylesheet($scheme->stylesheet);
			if ($scheme->script) $core->includeJavascript($scheme->script);

			$schemeParams = array('name' => $name, 'class' => 'scheme_' . $name);
			$schemeParams['attr'] = !empty($params) ? $params : array();
			$schemeParams['classNames'] = array('scheme', "scheme_{$name}");
			if (!empty($params['class'])) $schemeParams['classNames'][] = explode(' ', trim($params['class']));
			$schemeParams['serializedClassNames'] = implode(' ', $schemeParams['classNames']);			
			$schemeParams['id'] = !empty($params['id']) ? trim($params['id']) : '';			
			$schemeParams['serializedAttrs'] = 'class="' . $schemeParams['serializedClassNames'] . '"';			
			if (!empty($schemeParams['id'])) $schemeParams['serializedAttrs'] .= ' id="' . $schemeParams['id'] . '"';
			
			$prevScheme =& $smarty->get_template_vars('iScheme');
			$smarty->assign_by_ref('iScheme', $schemeParams);
			$smarty->assign('iSchemeClass', 'scheme_' . $name);			

			if (!empty($scheme->config)) {
				$smarty->config_load($scheme->config);
				$schemeConfig =& $smarty->get_config_vars();
			} else $schemeConfig = array();

			$header = '';
			$footer = '';
			$init = "\n<!-- Scheme {$name} starts -->\n";
			$deinit = "<!-- Scheme {$name} ends -->";

			if (!isset($schemeConfig['container']) || $schemeConfig['container'] !== false) {
				$init .= '<div ' . $schemeParams['serializedAttrs'] . '>';
				$deinit = "</div>\n" . $deinit;
			}

			$lifetime = $this->cache_lifetime;
			$this->cache_lifetime = 0;
			
			$hash = md5(implode('', $params));

			$cacheId = $this->getCacheAddress($name, $hash);
			$this->core->log("Fetching scheme {$name} with cache address {$cacheId}");

			switch ($display) {
			case 'header':	
				$header = empty($scheme->header) ? '' : $smarty->fetch($scheme->header, $cacheId);
				$body .= $init . sprintf("\n%s\n", $header);
				break;

			case 'footer':
				$footer = empty($scheme->footer) ? '' : $smarty->fetch($scheme->footer, $cacheId);
				$body .= sprintf("%s\n</div>\n<!-- Scheme %s ends -->\n", $footer, $name);
				break;

			case 'all':
			default:
				$header = empty($scheme->header) ? '' : $smarty->fetch($scheme->header, $cacheId);
				$footer = empty($scheme->footer) ? '' : $smarty->fetch($scheme->footer, $cacheId);
				$body .= $init . sprintf("\n%s\n%s\n%s\n%s\n", $header, $content, $footer, $deinit);
				break;
			}

			$this->cache_lifetime = $lifetime;
			
			unset($init, $deinit, $header, $footer);

			if (!empty($prevScheme)) $smarty->assign_by_ref('iScheme', $prevScheme);
			else $smarty->clear_assign('iScheme');

			return $body;
		}		

		function smarty_function_iSchemeInclude($params, &$smarty)
		{
			if (!isset($params['name']) || !isset($params['type'])) return;

			$core =& $smarty->core;

			$scheme =& $core->schemeManager->getScheme($params['name']);
			if ($core->schemeManager->isError($scheme))
				return ('Scheme <b>' . $name . '</b> error: ' . $scheme->getMessage() . '<br/>');
			if ($scheme === false)
				return ('Scheme <b>' . $name . '</b> not found<br/>');

			switch (strtolower($params['type']))
			{
			case 'css':
				if (!empty($scheme->stylesheet)) $core->includeStylesheet($scheme->stylesheet);
				break;

			case 'js':
				if (!empty($scheme->script)) $core->includeJavascript($scheme->script);
				break;
				
			default:
				return;
			}
		}

		function smarty_function_iIncludeCSS($params, &$smarty)
		{
			if (!isset($params['file'])) return;

			$smarty->core->includeStylesheet($params['file']);
		}

		function smarty_function_iIncludeJS($params, &$smarty)
		{
			if (!isset($params['file'])) return;

			$smarty->core->includeJavascript($params['file']);
		}

		function smarty_function_iIncludeTemplate($params, &$smarty)
		{
			if (!isset($params['file'])) return;

			$lifetime = $smarty->cache_lifetime;
			$this->cache_lifetime = 0;
			$content =& $smarty->fetch($smarty->core->_root . DIRECTORY_SEPARATOR . $params['file'], $smarty->core->cacheAddress);
			$this->cache_lifetime = $lifetime;
			
			return $content;
		}
	}

?>
