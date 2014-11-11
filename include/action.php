<?php

	require_once('object.php');

	define('IPARAM_GETPOST', 0);
	define('IPARAM_FILE', 1);

	define('IACTION_TEMPLATE_EXT', 'tpl');
	define('IACTION_CONF_EXT', 'conf');
	define('IACTION_SCRIPT_EXT', 'js');
	define('IACTION_STYLE_EXT', 'css');

	class iAction extends iObject
	{
		var $name = '';
		var $tplDir = '';
		var $styleDir = '';
		var $scriptDir = '';
		var $configDir = '';

		var $params = array();
		var $_lastProcessedArgument = '';

		var $cacheLifeTime = 0;
		var $paginate = null;

		var $modes = array(
			'xhtml' => null,
			'ajax' => null,
			'xml' => null
		);

		function & factory($name)
		{
			$obj =& new iAction($name);
			return $obj;
		}

		function iAction($name)
		{
			parent::iObject();

			$this->name = $name;
			$this->setHandler('on' . $this->name, IMODE_DEFAULT);
		}

		function & copyFromTo(&$src, &$dst, $deep = true)
		{
			$dst->params =& array_merge($dst->params, $src->params);
			
			if (!$deep) return $action;
			
			$vars = get_object_vars($src);
			unset($vars['name']);
			unset($vars['_methodName']);
			unset($vars['params']);
			
			foreach ($vars as $var) $dst->$var = $src->$var;
			
			return $action;
		}

		function & clone1($newName, $deep = true)
		{
			$action =& iAction::factory($newName);
			return $this->copyFromTo($this, $action, $deep);
		}

		function & getParam($name)
		{
			if (!is_string($name) || empty($name)) return $this->raiseError(null, IERROR_PARAMS);

			require_once('actionparam.php');
			
			$name = strtolower($name);
			if (isset($this->params) && isset($this->params[$name])) return $this->params[$name];
			else return $this->raiseError(null, IERROR_NOT_FOUND);
		}

		function & registerParam($name, $required = true)
		{
			if (!is_string($name) || empty($name) || !is_bool($required)) return $this->raiseError(null, IERROR_PARAMS);
	
			require_once('actionparam.php');

			$name = strtolower($name);
			$this->params[$name] =& iActionParam::factory($name, $required);

			return $this->params[$name];
		}

		function resolveName($value, $type)
		{
			switch (strtolower($type))
			{
				case 'template':
					$ext = IACTION_TEMPLATE_EXT;
					$dir =& $this->tplDir;
					break;

				case 'config':
					$ext = IACTION_CONF_EXT;
					$dir =& $this->confDir;
					break;

				case 'script':
					$ext = IACTION_SCRIPT_EXT;
					$dir =& $this->scriptDir;
					break;

				case 'style':
					$ext = IACTION_STYLE_EXT;
					$dir =& $this->styleDir;
					break;
					
				default:
					return $this->raiseError(null, IERROR_PARAMS);
			}
			
			$info = pathinfo($value);
			
			if (empty($info['basename'])) return $this->raiseError(null, IERROR_PARAMS);

			if (empty($info['extension'])) $info['extension'] = $ext;
			else $info['extension'] = strtolower($info['extension']);
			
			if ($info['extension'] != $ext) return $this->raiseError(null, IERROR_PARAMS);
			$info['basename'] = basename($info['basename'], '.' . $info['extension']);

			if (empty($info['dirname']) || $info['dirname'] == '.') $info['dirname'] = $dir;
			if (iFile::isAbsolute($info['dirname'])) $info['dirname'] = realpath($info['dirname']);
			else $info['dirname'] = realpath($dir . DIRECTORY_SEPARATOR . $info['dirname']);

			$info['filename'] = $info['basename'] . '.' . $info['extension'];
			$info['path'] = $info['dirname'] . DIRECTORY_SEPARATOR . $info['filename'];

			if (!file_exists($info['path'])) $info['path'] = '';
			
			return $info;
		}
		
		function initModeParams($mode = IMODE_DEFAULT)
		{
			if (!empty($this->modes[$mode])) return;
			
			$this->modes[$mode] = array(
				'handler' => '',
			  	'template' => '',
				'config' => '',
				'script' => '',
				'style' => array(
			  		'default' => '',
			  		'ie' => '',
			  		'ie5' => '',
			  		'ie6' => ''
			  	)
			);
		}
		
		function _setTemplate($type, $template, $mode = null)
		{
			if (!is_string($template) || empty($template)) return $this->raiseError(null, IERROR_PARAMS);

			if (!empty($mode)) {
				if (!is_string($mode)) return $this->raiseError(null, IERROR_PARAMS);
				$mode = strtolower($mode);
			}
			
			$info = $this->resolveName($template, $type);
			if ($this->isError($info)) return $info;
			
			$filename = $info['filename'];
			
			if (!empty($mode)) {
				$this->initModeParams($mode);
				
				if ($mode == 'xhtml') $this->modes[$mode][$type] = $info['dirname'] . DIRECTORY_SEPARATOR . $filename;
				else $this->modes[$mode][$type] = $info['dirname'] . DIRECTORY_SEPARATOR . $mode . DIRECTORY_SEPARATOR . $filename;				

				if (!file_exists($this->modes[$mode][$type])) $this->modes[$mode][$type] = '';
			} else {
				foreach ($this->modes as $tplmode => $value) {
					$this->initModeParams($tplmode);
					
					if ($tplmode == 'xhtml') $this->modes[$tplmode][$type] = $info['dirname'] . DIRECTORY_SEPARATOR . $filename;
					else $this->modes[$tplmode][$type] = $info['dirname'] . DIRECTORY_SEPARATOR . $tplmode . DIRECTORY_SEPARATOR . $filename;
					
					if (!file_exists($this->modes[$tplmode][$type])) $this->modes[$tplmode][$type] = '';
				}
			}

			return true;
		}

		function setTemplate($template, $mode = null)
		{
			return $this->_setTemplate('template', $template, $mode);			
		}

		function getTemplate($mode = IMODE_DEFAULT)
		{
			if (!isset($this->modes[$mode])) return $this->raiseError(null, IERROR_PARAMS);

			if (empty($this->modes[$mode])) return '';
			else return $this->modes[$mode]['template'];
		}

		function setTemplateConfig($template, $mode = null)
		{
			return $this->_setTemplate('config', $template, $mode);
		}		

		function getTemplateConfig($mode = IMODE_DEFAULT)
		{
			if (!isset($this->modes[$mode])) return $this->raiseError(null, IERROR_PARAMS);			

			if (empty($this->modes[$mode])) return '';
			else return $this->modes[$mode]['config'];
		}

		function setScript($value, $mode = null)
		{
			$path = $this->resolveName($value, 'script');
			if ($this->isError($path)) return $path;
			
			if (empty($mode)) {
				foreach ($this->modes as $key => $val) {
					$this->initModeParams($key);
					$this->modes[$key]['script'] = $path['path'];
				}
			} else {
				$this->initModeParams($mode);
				$this->modes[$mode]['script'] = $path['path'];
			}
			
			return true;
		}

		function getScript($mode = IMODE_DEFAULT)
		{
			if (!isset($this->modes[$mode])) return $this->raiseError(null, IERROR_PARAMS);
			
			if (empty($this->modes[$mode])) return '';
			else return $this->modes[$mode]['script'];
		}

		function setStyle($value, $version = 'default', $mode = null)
		{
			$path = $this->resolveName($value, 'style');
			if ($this->isError($path)) return $path;
			
			$version = strtolower($version);
			
			if (empty($mode)) {
				foreach ($this->modes as $key => $val) {
					$this->initModeParams($key);
					$this->modes[$key]['style'][$version] = $path['path'];
				}
			} else {
				$this->initModeParams($mode);
				$this->modes[$mode]['style'][$version] = $path['path'];
			}
			
			return true;
		}

		function getStyle($mode = IMODE_DEFAULT, $version = 'default')
		{
			if (!isset($this->modes[$mode])) return $this->raiseError(null, IERROR_PARAMS);

			$version = strtolower($version);

			if (empty($this->modes[$mode])) return '';
			else return $this->modes[$mode]['style'][$version];
		}

		function setHandler($value, $mode = null)
		{
			if (empty($mode)) {
				foreach ($this->modes as $key => $val) {
					$this->initModeParams($key);
					$this->modes[$key]['handler'] = $value;
				}
			} else {
				$this->initModeParams($mode);
				$this->modes[$mode]['handler'] = $value;
			}
			
			return true;
		}

		function getHandler($mode = IMODE_DEFAULT)
		{
			if (!isset($this->modes[$mode])) return $this->raiseError(null, IERROR_PARAMS);
			
			if (empty($this->modes[$mode])) return '';
			else return $this->modes[$mode]['handler'];
		}
	}

?>
