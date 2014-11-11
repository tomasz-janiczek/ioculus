<?php

	class iModule_Archive_Item extends iModuleDB
	{
		var $separator = '_';

		function & onListForm(&$core, &$args)
		{
			$result =& $this->onList($core, $args);
			if ($this->isError($result)) return $result;
			
			$list = array();
			foreach ($result as $key => $val) {
				$nameInfo = $this->onParseName($core, $params = array('id' => $val, 'return' => 'all'));
				if ($this->isError($nameInfo)) continue;

				$info = $this->onDetails($core, $params = array('id' => $val, 'archiveid' => $args['id']));
				if ($this->isError($info)) return $info;
				
				$info['size'] = iVFS::byte2($info['size'], null, true);
				
				$list[] = array_merge($nameInfo, $info);
			}

			$core->smarty->assign_by_ref('list', $list);
			
			return true;
		}

		function & onUploadForm(&$core, &$args)
		{
			$core->smarty->assign('action', $core->URL($this->name, 'upload', array('id' => $args['id'], 'var' => 'file')));
			
			return true;
		}

		function & onRefresh(&$core, &$args)
		{
			$result =& $this->onList($core, $args);
			if ($this->isError($result)) return $result;
			
			$path = $this->call($this->name, 'getpath', array('id' => $args['id']));
			if ($this->isError($path)) return $path;
			
			foreach ($result as $key => $val) {
				$nameInfo = $this->onParseName($core, $params = array('id' => $val, 'return' => 'all'));
				if ($this->isError($nameInfo)) {
					$name = $path . DIRECTORY_SEPARATOR . $this->onMakeName($core, $params = array('id' => $args['id'], 'name' => $val));
					$val = $path . DIRECTORY_SEPARATOR . $val;
					if (rename($val, $name) === false) return $this->raiseError(null, IERROR_FILE);
				}
			}
			
			return true;
		}
		
		function & onIsName(&$core, &$args)
		{
			if (strpos($args['id'], $this->separator) === false) return false;

			if (!empty($args['return']) && $args['return'] == 'all') $all = true;
			else $all = false;

			$info = pathinfo($args['id']);

			$x = explode($this->separator, $info['basename']);
			if (count($x) < 2) return false;
			if (!is_numeric($x[0])) return false;

			$info['id'] = $x[0];
			$info['name'] = implode('_', array_slice($x, 1));
			$info['filename'] = $info['basename'];
			unset($info['basename']);
			
			if ($all) return $info;
			else return true;
		}	

		function & onParseName(&$core, &$args)
		{
			$result = $this->onIsName($core, $params = array('id' => $args['id'], 'return' => 'all'));
			if ($result === false) return $this->raiseError(null, IERROR_PARAMS);
			
			return $result;
		}	

		function & onMakeName(&$core, &$args)
		{
			$info = pathinfo($args['name']);
			$name = $args['id'] . $this->separator . $info['basename'];
			
			return $name;
		}

		// dirs: id
		// files: archiveID_filenameID[.ext]
	
		function & onExists(&$core, &$args)
		{
			$path = $this->onGetPath($core, $params = array('id' => $args['id'], 'absolute' => true));
			if ($this->isError($path)) return false;
			
			return file_exists($path);
		}

		function & onGetPath(&$core, &$args)
		{
			$info = $this->onParseName($core, $args);
			if ($this->isError($info)) return $info;
				
			$path = $this->call($this->name, 'getpath', $params = array('id' => $info['id'], 'absolute' => true));
			if ($this->isError($path)) return $path;
			
			$path .=  DIRECTORY_SEPARATOR . $info['filename'];
			
			if (!empty($args['absolute']) && $args['absolute'] == true) return $path;
			else return iVFS::relativePath($path, $core->_root);
		}

		function & onList(&$core, &$args)
		{	
			$path = $this->call($this->name, 'getpath', array('id' => $args['id']));
			if ($this->isError($path)) return $path;
		
			require_once('file.php');
			
			$list =& iFile::getFileList($path);
			if ($list === false) return $this->raiseError(null, IERROR_NOT_FOUND);
			
			foreach ($list as $key => $val) {
				
			}
			
			if (empty($args['return'])) $args['return'] = 'raw';
			
			switch ($args['return']) {
			case 'options':
				$result = array();
				foreach ($list as $key => $val) $result[$val] = $val;
				break;
			
			case 'raw':
			default:
				$result =& $list;
				break;
			}

			return $result;
		}

		function & onAdd(&$core, &$args)
		{
			$srcPath = realpath($args['name']);
			if (!file_exists($srcPath)) return $this->raiseError(null, IERROR_NOT_FOUND);

			$archivePath = $this->call($this->name, 'getpath', $args);
			if ($this->isError($archivePath)) return $archivePath;
			
			$dstPath = $archivePath . DIRECTORY_SEPARATOR .
						$this->onMakeName($core, $params = array('id' => $args['id'], 'name' => $srcPath));
			
			if (!copy($srcPath, $dstPath)) return $this->raiseError(null, IERROR_FILE);
			if (!empty($args['delete']) && $args['delete'] == true) {
				if (unlink($srcPath) === false) return $this->raiseError(null, IERROR_FILE);
			}

			return $dstPath;
		}

		function & onDeleteSingle(&$core, &$args)
		{
			$path = $this->onGetPath($core, $params = array_merge($args, array('absolute' => true)));
			if ($this->isError($path)) return $path;
			
			if (unlink($path) === false) return $this->raiseError(null, IERROR_FILE);
			
			return true;
		}

		function & onDetails(&$core, &$args)
		{
			$path = $this->onGetPath($core, $params = array_merge($args, array('absolute' => true)));
			if ($this->isError($path)) {
				if (empty($args['archiveid'])) return $path;
				else {
					$path = $this->call($this->name, 'getpath', $params = array('id' => $args['archiveid'], 'absolute' => true));
					if ($this->isError($path)) return $path;					

					$path .= DIRECTORY_SEPARATOR . $args['id'];
				}
			}
			
			$info = stat($path);
			if ($info === false) return $this->raiseError(null, IERROR_FILE);
			
			return $info;
		}

		function & onValidate(&$core, &$args)
		{
			return $this->itemExistsInArchive($args['id'], $args['name']);
		}

		function & onUpload(&$core, &$args)
		{
			$archivePath = $this->call($this->name, 'getpath', $params = array_merge($args, array('absolute' => true)));
			if ($this->isError($archivePath)) return $archivePath;

			require_once('upload.php');

			$options = array(
				'randomNames' => 'ifExists',
				'namePrefix' => "{$args['id']}_",
				'overwrite' => false
			);			
			$upload =& iUpload::factory($archivePath, $options);
			
			$srcPath = $upload->uploadFile($args['var']);
			if ($this->isError($srcPath)) return $srcPath;

			return $dstPath;
		}
		
		function & onDownload(&$core, &$args)
		{
			$path = $this->onGetPath($core, $params = array_merge($args, array('absolute' => true)));
			if ($this->isError($path)) {
				if (empty($args['archiveid'])) return $path;
				else {
					$path = $this->call($this->name, 'getpath', $params = array('id' => $args['archiveid'], 'absolute' => true));
					if ($this->isError($path)) return $path;					

					$path .= DIRECTORY_SEPARATOR . $args['id'];
				}
			}		
		
			$info = $this->onParseName($core, $params = array('id' => $path, 'return' => 'all'));
			if ($this->isError($info)) $name = basename($path);
			else $name = $info['name'];
		
			require_once('HTTP/Download.php');
			
			$params = array(
				'file' => $path,
				'contentdisposition' => array(HTTP_DOWNLOAD_ATTACHMENT, $name),
			);			
			 $error = HTTP_Download::staticSend($params, true);
			 if (PEAR::isError($error)) return $error;
			 
			 return true;
		}

		// Non-public action. Compresses a uploaded file into a ZIP archive.
		function & onZipItem(&$msg, &$core, &$args)
		{
			if ($args['compress'] == 0 || $args['compress_format'] != 'zip') return true;
			
			require_once('Archive/Zip.php');

			$path = pathinfo($args['path']);
			$zipPath = iVFS::buildPath(array($path['dirname'], basename($path['basename'], $path['extension']) . 'zip'));
			
			// Check if the given file isn't already a ZIP archive
			$zip =& new Archive_Zip($args['path']);
			$prop =& $zip->properties();
			unset($zip);
			if ($prop != 0 && !empty($prop['nb'])) {
				if (strtolower($path['extension']) != 'zip') {
					$core->vfs->move($path['dirname'], $path['basename'], $zipPath);
					$args['path'] = $zipPath;
				}
				return true;
			}
			
			// It isn't. Zip the given file.
			$zip =& new Archive_Zip($zipPath);
			$result =& $zip->create($args['path'], $this->zipParams);
			unset($zip);
			if ($result[0]['status'] != 'ok') return $this->raiseError('Kompresja pliku nie powiodła się');
			
			$core->vfs->deleteFile($path['dirname'], $path['basename']);
			$args['path'] = $zipPath;
			
			return true;		
		}

	}

?>
