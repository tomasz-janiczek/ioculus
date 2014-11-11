<?php

	require_once('dispatcher.php');

	class iXMLModuleParser extends iDispatcher
	{
		function & singleton()
		{
			static $instance = null;

			if (!$instance) $instance =& iXMLModuleParser::factory();

			return $instance;
		}

		function & factory()
		{
			$obj =& new iXMLModuleParser();
			return $obj;
		}
		
		function load($path, $params = array())
		{
			if (!is_string($path) || empty($path)) return $this->raiseError(null, IERROR_PARAMS);
			if (!file_exists($path)) return $this->raiseError(null, IERROR_FILE_NOT_FOUND);

			require_once('module.php');
			require_once('domit/xml_domit_include.php');
			
			if (!isset($this->domit)) $this->domit =& new DOMIT_Document();
			
			if (!$this->domit->loadXML($path)) return $this->raiseError(null, IERROR_XML_LOAD);
			
			return parent::post($args = array(&$this->domit, &$params));
		}

		function _arrayToString_checkKeys(&$value, &$key, $userdata = null)
		{
			static $_index = 0;
			
			if (is_numeric($key)) {
				printf(" yes\n<br/>");
				$key = 'iItem' . $_index;
				$_index++;
			} else printf(" no\n<br/>");
			
			return true;
		}

		function array_walk_recursive2(&$input, $func, $userdata = null)
		{			
			if (!is_array($input)) return false;

			foreach ($input as $key => $value) {
				$saved_value = $value;
				$saved_key = $key;
				if (!empty($userdata)) call_user_func($func, &$value, &$key, $userdata);
				else call_user_func($func, &$value, &$key);
					
				if ($value != $saved_value || $saved_key != $key) {
					unset($input[$saved_key]);
					$input[$key] = $value;
				}

				if (is_array($input[$key])) {
					iXMLParser::array_walk_recursive2($input[$key], $func, $userdata);
				} else {
					$saved_value = $value;
					$saved_key = $key;
					if (!empty($userdata)) call_user_func($func, &$value, &$key, $userdata);
					else call_user_func($func, &$value, &$key);
						
					if ($value != $saved_value || $saved_key != $key) {
						unset($input[$saved_key]);
						$input[$key] = $value;
					}
				}
			}
			
			return true;
		}

		function & _arrayToString_renderSimpleElement($name, $value)
		{	
			if (!empty($value)) return sprintf("<%s>%s</%s>", $name, htmlspecialchars($value), $name);
			else return sprintf("<%s/>", $name);
		}

		function & _arrayToString_tag($name, $caller = null)
		{
			if (!is_numeric($name)) return $name;
			else {
				if (!empty($caller)) return $caller . '_item';
				else return '_item';
			}
		}

		function & arrayToString(&$xmlArray, $caller = null)
		{
			$xml = '';
			
			foreach ($xmlArray as $key => $value) {
				if (is_array($xmlArray[$key])) {
					if (empty($xmlArray[$key])) {
						$xml .= iXMLParser::_arrayToString_renderSimpleElement(iXMLParser::_arrayToString_tag($key, $caller), '');
					} else {
						$content =& iXMLParser::arrayToString($xmlArray[$key], $key);
						if (!empty($content))
							$xml .= sprintf("<%s>%s</%s>", iXMLParser::_arrayToString_tag($key, $caller), $content,
									      iXMLParser::_arrayToString_tag($key, $caller));
						else
							$xml .= sprintf("<%s/>", $key);
					}
				} else {
					$xml .= iXMLParser::_arrayToString_renderSimpleElement(iXMLParser::_arrayToString_tag($key, $caller), $value);
				}
			}
			
			return $xml;
		}
		
		function & xml_version(&$dom, &$args)
		{
			$module =& $args['module'];
		    
			$element =& $dom->getElementsByPath("/module/version", 1);
			if (!$element) return true;
		    
			$module->version = $element->getText();

			return true;
		}

		function & xml_description(&$dom, &$args)
		{
			$module =& $args['module'];
					    
			$element =& $dom->getElementsByPath("/module/description", 1);
			if (!$element) return true;
		    
			$module->description = $element->getText();

			return true;
		}

		function & xml_author(&$dom, &$args)
		{
			$module =& $args['module'];
					    
			$element =& $dom->getElementsByPath("/module/author", 1);
			if (!$element) return true;

			$module->author = $element->getText();

			return true;
		}

		function & xml_action(&$dom, &$args)
		{
			$module =& $args['module'];
					    
			$actions =& $dom->getElementsByPath("/module/action");
			if (!$actions) return true;
		    
			require_once('action.php');
			
			for ($i = 0;$i < $actions->getLength();$i++) {
				$act =& $actions->item($i);

				if (!$act->hasAttribute('name')) die('Action lacks the "name" attribute');
				
				$actname = $act->getAttribute('name');
				
				$tmp =& $module->getAction($actname);
				if (!$this->isError($tmp)) die("Action {$actname} already exists");
				
				$action =& iAction::factory($act->getAttribute('name'));
				
				$action->tplDir = $module->templateDir;
				$action->configDir = $module->templateDir;
				$action->styleDir = $module->styleDir;
				$action->scriptDir = $module->scriptDir;

				$action->setScript($action->name);
				$action->setStyle($action->name);
				$action->setStyle('ie' . DIRECTORY_SEPARATOR . $action->name, 'IE');
				$action->setStyle('ie5' . DIRECTORY_SEPARATOR . $action->name, 'IE5');
				$action->setStyle('ie6' . DIRECTORY_SEPARATOR . $action->name, 'IE6');

				$result = $action->setTemplate($action->name);
				if ($this->isError($result)) die($result->getMessage());

				$result = $action->setTemplateConfig($action->name);
				if ($this->isError($result)) die($result->getMessage());
								
				if ($act->hasAttribute('defaultAction') && $act->getAttribute('defaultAction') === 'true') $module->_defaultAction = $action->name;

				if ($act->hasAttribute('pagination') && $act->getAttribute('pagination') === 'true')
				{
					require_once('pagination.php');
					
					$action->paginate =& iPagination::factory();
					$action->paginate->id = $module->name . '_' . $action->name;
				}

				if ($act->hasAttribute('cache'))
				{
					if ($act->getAttribute('cache') === 'false') $action->cacheLifeTime = 0;
					else $action->cacheLifeTime = (int) $act->getAttribute('cache');
				} else $action->cacheLifeTime = $module->_core->smarty->defaultCacheLifeTime;
				
				$result =& $module->registerAction($action);
				if ($this->isError($result)) return $result;
			}

			return true;
		}

		function & xml_template(&$dom, &$args)
		{
			$module =& $args['module'];	

			$element =& $dom->getElementsByPath("/module/action/template");
			if (!$element) return true;
		    
			require_once('action.php');
			
			for ($i = 0;$i < $element->getLength();$i++) {
				$tpl =& $element->item($i);
			
				$action =& $module->getAction($tpl->parentNode->getAttribute('name'));
				if (!$action) return $this->raiseError("Couldn't get the action " . $tpl->parentNode->getAttribute('name'));
				
				if ($tpl->hasAttribute('mode')) $mode = $tpl->getAttribute('mode');
				else $mode = null;

				$template = $tpl->getText();
				if (empty($template)) continue;

				$result = $action->setTemplate($template, $mode);
				if ($this->isError($result)) die($result->getMessage());
			}

			return true;
		}

		function & xml_style(&$dom, &$args)
		{
			$module =& $args['module'];
					    
			$element =& $dom->getElementsByPath("/module/action/style");
			if (!$element) return true;
		    
			require_once('action.php');
			
			for ($i = 0;$i < $element->getLength();$i++) {
				$tpl =& $element->item($i);
			
				$action =& $module->getAction($tpl->parentNode->getAttribute('name'));
				if (!$action) return $this->raiseError("Couldn't get the action " . $tpl->parentNode->getAttribute('name'));

				$content = $tpl->getText();
				if (empty($content)) $action->stylesheet = '';
				else if ($tpl->hasAttribute('relative') && $tpl->getAttribute('relative') === 'false')
					$action->stylesheet = iVFS::buildPath(array($module->_core->_www, $content));
				else
					$action->stylesheet = iVFS::buildPath(array($module->styleDir, $content));
			}

			return true;
		}

		function & xml_script(&$dom, &$args)
		{
			$module =& $args['module'];
					    
			$element =& $dom->getElementsByPath("/module/action/script");
			if (!$element) return true;
		    
			require_once('action.php');
			
			for ($i = 0;$i < $element->getLength();$i++) {
				$tpl =& $element->item($i);
			
				$action =& $module->getAction($tpl->parentNode->getAttribute('name'));
				if (!$action) return $this->raiseError("Couldn't get the action " . $tpl->parentNode->getAttribute('name'));

				$content = $tpl->getText();
				if (empty($content)) $action->stylesheet = '';
				else if ($tpl->hasAttribute('relative') && $tpl->getAttribute('relative') === 'false')
					$action->script = iVFS::buildPath(array($module->_core->_www, $content));
				else
					$action->script = iVFS::buildPath(array($module->scriptDir, $content));
			}

			return true;
		}

		function & xml_handler(&$dom, &$args)
		{
			$module =& $args['module'];
					    
			$element =& $dom->getElementsByPath("/module/action/handler");
			if (!$element) return true;

			require_once('action.php');
			
			for ($i = 0;$i < $element->getLength();$i++) {
				$tpl =& $element->item($i);

				$action =& $module->getAction($tpl->parentNode->getAttribute('name'));
				if (!$action) return $this->raiseError("Couldn't get the action " . $tpl->parentNode->getAttribute('name'));

				$action->_methodName = $tpl->getText();
			}

			return true;
		}


		function & xml_param(&$dom, &$args)
		{
			$module =& $args['module'];
			
			$element =& $dom->getElementsByPath("/module/action/param");
			if (!$element) return true;
		    
			require_once('action.php');
			
			for ($i = 0;$i < $element->getLength();$i++) {
				$tpl =& $element->item($i);

				if ($tpl->hasAttribute('required') && $tpl->getAttribute('required') === 'false') $required = false;
				else $required = true;
			
				$action =& $module->getAction($tpl->parentNode->getAttribute('name'));
				if (!$action) return $this->raiseError("Couldn't get the action " . $tpl->parentNode->getAttribute('name'));

				$param =& $action->registerParam($tpl->getAttribute('name'), $required);
				if ($this->isError($param)) return $param;

				if ($tpl->hasAttribute('type') && $tpl->getAttribute('type') === 'file') {
					$param->type = IPARAM_FILE;
					if ($tpl->hasAttribute('min')) $param->minSize = iVFS::units2bytes($tpl->getAttribute('min'));
					if ($tpl->hasAttribute('max')) $param->maxSize = iVFS::units2bytes($tpl->getAttribute('max'));
					if ($tpl->hasAttribute('size')) $param->requiredSize = iVFS::units2bytes($tpl->getAttribute('size'));
					if ($tpl->hasAttribute('mime')) {
						$value = $tpl->getAttribute('mime');
						$param->mimeTypes = strstr($value, ',') ? explode(',', $value) : array($value);
						foreach ($param->mimeTypes as $key => $value)
							$param->mimeTypes[$key] = strtolower(strtr($param->mimeTypes[$key], ' ', ''));
					}
				} else $param->type = IPARAM_GETPOST;
			}

			return true;
		}

		function & xml_modifier(&$dom, &$args)
		{
			$module =& $args['module'];
					    
			$element =& $dom->getElementsByPath("/module/action/param/modifier");
			if (!$element) return true;
		    
			require_once('action.php');
			
			for ($i = 0;$i < $element->getLength();$i++) {
				$tpl =& $element->item($i);

				$action =& $module->getAction($tpl->parentNode->parentNode->getAttribute('name'));
				if (!$action) return $this->raiseError("Couldn't get the action " . $tpl->parentNode->getAttribute('name'));
				
				$param =& $action->getParam($tpl->parentNode->getAttribute('name'));

				$attributes = $tpl->attributes->toArray();
				unset($attributes['name']);
				
				$param->registerModifier($tpl->getAttribute('name'), $attributes);

			}

			return true;
		}

		function & xml_validator(&$dom, &$args)
		{
			$module =& $args['module'];
					    
			$element =& $dom->getElementsByPath("/module/action/param/validator");
			if (!$element) return true;
		    
			require_once('action.php');
			
			for ($i = 0;$i < $element->getLength();$i++) {
				$tpl =& $element->item($i);

				$action =& $module->getAction($tpl->parentNode->parentNode->getAttribute('name'));
				if (!$action) return $this->raiseError("Couldn't get the action " . $tpl->parentNode->getAttribute('name'));
				
				$param =& $action->getParam($tpl->parentNode->getAttribute('name'));

				$attributes = $tpl->attributes->toArray();
				unset($attributes['name']);
				
				$param->registerValidator($tpl->getAttribute('name'), $attributes);
			}

			return true;
		}

		function & xml_validator_error(&$dom, &$args)
		{
			$module =& $args['module'];
					    
			$element =& $dom->getElementsByPath("/module/action/param/validator/error");
			if (!$element) return true;
		    
			require_once('action.php');
			
			for ($i = 0;$i < $element->getLength();$i++) {
				$tpl =& $element->item($i);

				$action =& $module->getAction($tpl->parentNode->parentNode->parentNode->getAttribute('name'));
				if (!$action) return $this->raiseError("Couldn't get the action " . $tpl->parentNode->getAttribute('name'));
				
				$param =& $action->getParam($tpl->parentNode->parentNode->getAttribute('name'));
				if (iObject::isError($param)) return $this->raiseError("Couldn't get the parameter " . $tpl->parentNode->parentNode->getAttribute('name'));
				
				$validator =& $param->getValidator($tpl->parentNode->getAttribute('name'));
				if (iObject::isError($validator)) return $this->raiseError("Couldn't get the validator " . $tpl->parentNode->getAttribute('name'));

				$attributes = $tpl->attributes->toArray();
				
				$validator['_errorText'] = $tpl->getText();
				if (isset($attributes['title'])) $validator['_errorTitle'] = $attributes['title'];
			}
			
			return true;
		}
				
		function & xml_type(&$dom, &$args)
		{
			$module =& $args['module'];
					    
			$element =& $dom->getElementsByPath("/module/type", 1);
			if (!$element) return true;
		    
			if ($element->getText() === 'system') $module->type = IMOD_SYSTEM;
			else $module->type = IMOD_EXTENSION;

			return true;
		}

		function & xml_menu(&$dom, &$args)
		{
			$module =& $args['module'];
			$core =& $module->_core;
		    
			$element =& $dom->getElementsByPath("/module/menu/item");
			if (!$element) return true;

			require_once('action.php');			

			for ($i = 0;$i < $element->getLength();$i++) {
				$tpl =& $element->item($i);

				if (!$tpl->hasAttribute('name'))
					return $this->raiseError("A menu <item> element must have the 'name' attribute");	
				$name = $tpl->getAttribute('name');

				if ($tpl->hasAttribute('index')) $position = $tpl->getAttribute('index');
				else $position = null;

				if (!$core->menu->topLevelExists($name)) {
					if ($tpl->hasAttribute('module') && $tpl->hasAttribute('action')) {
						$url = $core->uRL($tpl->getAttribute('module'), $tpl->getAttribute('action'), array());
					} else if ($tpl->hasAttribute('url')) {
						$url = $tpl->getAttribute('url');
					} else $url = '';

					$core->menu->addTopLevel($name, $url, $position);
				}
				
				if ($tpl->hasChildNodes()) {
  					$nodes =& $tpl->childNodes;
  					
					for ($j = 0;$j < $tpl->childCount;$j++) {
						$item =& $nodes[$j];

						if (!$item->hasAttribute('name'))
							return $this->raiseError("A menu <item> element must have the 'name' attribute");

						if ($item->hasAttribute('module') && $item->hasAttribute('action')) {
							$urlParams = $item->attributes->toArray();
							unset($urlParams['name']);
							unset($urlParams['module']);
							unset($urlParams['action']);
							$url = $core->url($item->getAttribute('module'), $item->getAttribute('action'), $urlParams);
						} else if ($item->hasAttribute('url')) {
							$url = $item->getAttribute('url');
						} else $url = '';

						$core->menu->addFirstLevel($name, $item->getAttribute('name'), $url);
					}
				}
			}
			
			return true;
		}

		function & xml_extend(&$dom, &$args)
		{
			$module =& $args['module'];
			$core =& $module->_core;

			$actions =& $dom->getElementsByPath("/module/action");
			if (!$actions) return true;

			require_once('action.php');

			for ($i = 0;$i < $actions->getLength();$i++) {
				$act =& $actions->item($i);

				if ($act->hasAttribute('extend')) {
					$matches = array();
					if (preg_match("/^(public|private)*[:]*([^$]*)$/", $act->getAttribute('extend'), $matches)) {
						foreach ($matches as $key => $value) $matches[$key] = strtolower($value);
						if (!empty($matches[1]) && $matches[1] === 'private') $deep = true;
						else $deep = false;

						$srcAction =& $module->getAction($matches[2]);
						if ($this->isError($srcAction)) return $this->raiseError($srcAction);
						$dstAction =& $module->getAction($act->getAttribute('name'));
						if ($this->isError($dstAction)) return $this->raiseError($dstAction);
						
						$srcAction->copyFromTo($srcAction, $dstAction, $deep);
					}
				}
			}
			
			return true;
		}
	}

?>
