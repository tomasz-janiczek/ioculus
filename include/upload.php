<?php

	require_once('object.php');
	
	class iUpload extends iObject
	{	
		var $_root = '';
		var $_upload = null;
		var $_maxFileSize = 0;
		var $_extensions = array();
		var $_overwrite = false;
		var $_randomNames = 'ifExists';
		var $_namePrefix = '';
		var $_nameSuffix = '';
		var $_lastUpload = '';
		var $_lastOriginalName = '';

		function & factory($uploadDir, $options = array())
		{
			return new iUpload($uploadDir, $options);
		}
			
		function iUpload($root, $options = array())
		{
			parent::iObject();

			$this->_root = $root;
			if (!empty($options)) $this->setOptions($options);
		}
		
		function setOptions($options)
		{
			if (empty($options)) return;
			
			$validOptions = array('maxFileSize', 'extensions', 'overwrite', 'randomNames', 'namePrefix', 'nameSuffix');
			
			foreach ($options as $key => $val) {
				if (!in_array($key, $validOptions)) continue;
				$option = '_' . $key;
				$this->$option = $val;
			}
		}
		
		function getRoot()
		{
			return $this->_root;
		}

		function setRoot($value)
		{
			if (!is_string($value)) return $this->raiseError(null, IERROR_PARAMS);
			
			$this->_root = $value;
		}

		function getMaxFileSize()
		{
			return $this->_maxFileSize;
		}
		
		function setMaxFileSize($value)
		{
			if (!is_numeric($value)) return $this->raiseError(null, IERROR_PARAMS);
			
			$this->_maxFileSize = $value * 1024;
		}

		function getExt()
		{
			return $this->_extensions;
		}
		
		function setExt(&$value)
		{
			if (!is_array($value)) return $this->raiseError(null, IERROR_PARAMS);
			
			$this->_extensions = $value;
		}
		
		function addExt($value)
		{
			if (!is_string($value)) return $this->raiseError(null, IERROR_PARAMS);
			
			$this->_extensions[] = strtolower($value);
		}
		
		function clearExt()
		{
			unset($this->_extensions);
			$this->_extensions = array();
		}
		
		function doOverwrite($value)
		{
			if (!is_bool($value)) return $this->raiseError(null, IERROR_PARAMS);
			
			$this->_overwrite = $value;
		}

		function doRandomName($value)
		{
			if (is_bool($value) && $value === true) $this->_randomNames = 'always';
			else if (is_bool($value) && $value === false) $this->_randomNames = 'never';
			else $this->_randomNames = $value;
		}
	
		function setPrefix($value)
		{
			if (!is_string($value)) return $this->raiseError(null, IERROR_PARAMS);

			$this->_namePrefix = $value;
		}

		function setSuffix($value)
		{
			if (!is_string($value)) return $this->raiseError(null, IERROR_PARAMS);

			$this->_nameSuffix = $value;
		}

		function getOriginalName()
		{
			return $this->_lastOriginalName;
		}

		function getFinalPath()
		{
			return $this->_lastUpload;
		}
				
		function uploadFile($formVar, $name = '')
		{
			if (empty($formVar) || !is_string($name)) return $this->raiseError(null, IERROR_PARAMS);

			require_once('HTTP/Upload.php');

			if (empty($this->_upload)) $this->_upload =& new HTTP_Upload('en');

			$file =& $this->_upload->getFiles($formVar);
			if (PEAR::isError($file)) return $file;

			if (!$file->isValid()) return $this->raiseError(null, IERROR_UPLOAD);
			if ($this->_maxFileSize > 0 && $file->getProp('size') > $this->_maxFileSize) return $this->raiseError(null, IERROR_UPLOAD_SIZE);

			if (!empty($this->_extensions)) {								
				$ext = strtolower($file->getProp('ext'));
				if (!empty($ext)) {
					$match = 0;
					foreach ($this->_extensions as $key => $value) {
						if ($value === $ext) $match++;
					}
					if ($match === 0) return $this->raiseError(null, IERROR_UPLOAD_TYPE);
				}
			}

			$this->_lastOriginalName = $file->getProp('name');

			if (!empty($name)) $file->setName($name);
			else if (strtolower($this->_randomNames) === 'always') $file->setName('uniq', $this->_namePrefix, $this->_nameSuffix);
			else if (strtolower($this->_randomNames) === 'ifexists') {
				require_once('lang.php');
				
				$file->setName(iLang::normalizeName($file->getProp('name')), $this->_namePrefix, $this->_nameSuffix);
				$destPath = $this->_root . DIRECTORY_SEPARATOR . $file->getProp('name');
				if (file_exists($destPath)) $file->setName('uniq', $this->_namePrefix, $this->_nameSuffix);
			}

			$destPath = iVFS::buildPath(array($this->_root, $file->getProp('name')));
			if (file_exists($destPath) && $this->overwrite === false) return $this->raiseError(null, IERROR_FILE_EXISTS);

			$fileName = $file->moveTo($this->_root);
			if (PEAR::isError($fileName)) return $fileName;
			$this->_lastUpload = iVFS::buildPath(array($this->_root, $fileName));
						
			return $this->_lastUpload;
		}
	}

?>
