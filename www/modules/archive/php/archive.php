<?php

	class iModule_Archive extends iModuleDB
	{
		function & onListForm(&$core, &$args)
		{
			$result =& $this->onList($core, $args);
			if ($this->isError($result)) return $result;
			
			$list = array();
			foreach ($result as $key => $val) {
				$info = $this->onDetails($core, $params = array('id' => $val));
				if ($this->isError($info)) return $info;
			
				$info['size'] = iVFS::byte2($info['size'], null, true);
			
				$list[] = array_merge($info, array('id' => $val));
			}
			
			$core->smarty->assign_by_ref('list', $list);
			
			return true;
		}	
	
		function & onAddForm(&$core, &$args)
		{
			$core->smarty->assign('action', iCore::URL($this->name, 'add'));

			return true;
		}

		function & onEditForm(&$core, &$args)
		{
			$result =& $this->onDetailsForm($core, $args);
			if ($this->isError($result)) return $result;

			$core->smarty->assign_by_ref('compress_radios', $compress_radios);
			$core->smarty->assign('action', iCore::URL($this->name, 'edit', array('id' => $args['id'])));

			return true;
		}

		function & onDetailsForm(&$core, &$args)
		{
			$archive =& $this->archiveExists($args['id'], true);
			if ($archive === false) return $this->raiseError('Archiwum o id=' . $args['id'] . ' nie istnieje');

			$list =& $this->getItemList($archive['id']);
			if ($this->isError($list)) return $list;

			$core->smarty->assign_by_ref('items', $list);
			$core->smarty->assign_by_ref('archive', $archive);

			return true;
		}

		function & onExists(&$core, &$args)
		{
			$path = $this->uploadDir . DIRECTORY_SEPARATOR . $args['id'];
			if (file_exists($path)) return true;
			else return false;
		}

		function & onClear(&$core, &$args)
		{
			if (!$this->onExists($core, $args)) return $this->raiseError(null, IERROR_NOT_FOUND);
			
			$result = $this->onDeleteSingle($core, $args);
			if ($this->isError($result)) return $result;
			
			return $this->onAdd($core, $args);			
		}

		function & onList(&$core, &$args)
		{
			require_once('file.php');
			
			$list =& iFile::getDirectoryList($this->uploadDir);
			if ($list === false) return $this->raiseError(null, IERROR_NOT_FOUND);
			if (empty($list)) return $list;
			
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
			$list =& $this->onList($core, $args);
			if ($this->isError($list)) return $list;
			
			if (!empty($list)) $nextId = (int) max($list) + 1;
			else $nextId = 1;
				
			$path = $this->uploadDir . DIRECTORY_SEPARATOR . $nextId;
			
			if (file_exists($path)) return $this->raiseError(null, IERROR_FILE_EXISTS);
			if (!mkdir($path)) return $this->raiseError(null, IERROR_FILE);
			
			return $nextId;
		}

		function & onDeleteSingle(&$core, &$args)
		{
			$path = $this->onGetPath($core, $params = array('id' => $args['id'], 'absolute' => true));
			if ($this->isError($path)) return $path;
		
			$result = $core->vfs->deleteFolder(dirname($path), basename($path), true);
			if (!$result) return $this->raiseError(null, IERROR_FILE);
			
			return true;
		}

		function & onGetPath(&$core, &$args)
		{
			if (!$this->onExists($core, $args)) return $this->raiseError(null, IERROR_NOT_FOUND);
			
			$path = $this->uploadDir . DIRECTORY_SEPARATOR . $args['id'];
			if (!empty($args['absolute']) && $args['absolute'] == true) return $path;
			else return iVFS::relativePath($path, $core->_root);
		}

		function & onDetails(&$core, &$args)
		{
			$path = $this->onGetPath($core, $params = array('id' => $args['id'], 'absolute' => true));
			if ($this->isError($path)) return $path;

			require_once('file.php');
			
			$info = iFile::getDirectorySize($path);
			$info['id'] = $args['id'];
			$info['free_access'] = !$this->onIsLocked($core, $args);
			
			return $info;
		}

		function & onUnlock(&$core, &$args)
		{
			$path = $this->onGetPath($core, $params = array('id' => $args['id'], 'absolute' => true));
			if ($this->isError($path)) return $path;			

			$path .= DIRECTORY_SEPARATOR . '.htaccess';
			$htaccessPath = $this->uploadDir . DIRECTORY_SEPARATOR . 'htaccess.tpl';

			if (!file_exists($path))
				if (copy($htaccessPath, $path) === false) return $this->raiseError(null, IERROR_FILE);
					
			return true;
		}

		function & onLock(&$core, &$args)
		{
			$path = $this->onGetPath($core, $params = array('id' => $args['id'], 'absolute' => true));
			if ($this->isError($path)) return $path;			

			$path .= DIRECTORY_SEPARATOR . '.htaccess';

			if (file_exists($path))
				if (unlink($path) === false) return $this->raiseError(null, IERROR_FILE);
				
			return true;
		}

		function & onIsLocked(&$core, &$args)
		{
			$path = $this->onGetPath($core, $params = array('id' => $args['id'], 'absolute' => true));
			if ($this->isError($path)) return $path;			

			$path .= DIRECTORY_SEPARATOR . '.htaccess';

			clearstatcache();
			
			if (file_exists($path)) return false;
			else return true;
		}

		function & onSwitchLock(&$core, &$args)
		{
			if ($this->onIsLocked($core, $args)) return $this->onUnlock($core, $args);
			else return $this->onLock($core, $args);
		}

		// ARCHIVE ITEMS

		function & onListItemForm(&$core, &$args)
		{
			return $this->call('item', 'listform', $args);
		}

		function & onUploadForm(&$core, &$args)
		{
			return $this->call('item', 'uploadform', $args);
		}

		function & onAddItem(&$core, &$args)
		{
			return $this->call('item', 'add', $args);
		}

		function & onListItem(&$core, &$args)
		{
			return $this->call('item', 'list', $args);
		}

		function & onDeleteItem(&$core, &$args)
		{
			return $this->call('item', 'delete', $args);
		}

		function & onItemExists(&$core, &$args)
		{
			return $this->call('item', 'exists', $args);
		}

		function & onGetItemPath(&$core, &$args)
		{
			return $this->call('item', 'getpath', $args);
		}

		function & onMakeItemName(&$core, &$args)
		{
			return $this->call('item', 'makename', $args);
		}

		function & onParseItemName(&$core, &$args)
		{
			return $this->call('item', 'parsename', $args);
		}

		function & onIsItemName(&$core, &$args)
		{
			return $this->call('item', 'isname', $args);
		}

		function & onRefresh(&$core, &$args)
		{
			return $this->call('item', 'refresh', $args);
		}

		function & onItemDetails(&$core, &$args)
		{
			return $this->call('item', 'details', $args);
		}

		function & onUpload(&$core, &$args)
		{
			return $this->call('item', 'upload', $args);
		}

		function & onDownload(&$core, &$args)
		{
			return $this->call('item', 'download', $args);
		}
	}

?>
