<?php

	require_once('object.php');
	require_once('pear/File.php');

	define('IVFS_KILOBYTE', 1024);
	define('IVFS_MEGABYTE', 1000 * IVFS_KILOBYTE);
	define('IVFS_GIGABYTE', 1000 * IVFS_MEGABYTE);

	class iFile extends File
	{
		function & factory()
		{
			$obj =& new iFile();
			return $obj;
		}

		function & _getList($path, $type)
		{
			$objects = File_Util::listDir($path, $type, FILE_SORT_NAME);

			$dirs = array();
			foreach ($objects as $i) $dirs[] = $i->name;

			return $dirs;
		}

		function & getFileList($path)
		{
			if (!is_string($path) || empty($path)) return iObject::raiseError(null, IERROR_PARAMS);
			
			require_once('File/Util.php');
			
			return iFile::_getList($path, FILE_LIST_FILES);
		}

		function & getDirectoryList($path)
		{
			if (!is_string($path) || empty($path)) return iObject::raiseError(null, IERROR_PARAMS);

			require_once('File/Util.php');
			
			return iFile::_getList($path, FILE_LIST_DIRS);
		}

		function & getList($path)
		{
			if (!is_string($path) || empty($path)) return iObject::raiseError(null, IERROR_PARAMS);

			require_once('File/Util.php');
			
			return iFile::_getList($path, FILE_LIST_FILES | FILE_LIST_DIRS);
		}

		function getDirectorySize($path)
		{
			$totalsize = 0;
			$totalcount = 0;
			$dircount = 0;
			
			if ($handle = opendir ($path)) {
				while (false !== ($file = readdir($handle))) {
					$nextpath = $path . '/' . $file;
					if ($file != '.' && $file != '..' && !is_link ($nextpath)) {
						if (is_dir ($nextpath)) {
							$dircount++;
							$result = getDirectorySize($nextpath);
							$totalsize += $result['size'];
							$totalcount += $result['count'];
							$dircount += $result['dircount'];
						} elseif (is_file ($nextpath)) {
							$totalsize += filesize ($nextpath);
							$totalcount++;
						}
					}
				}
			}
			closedir ($handle);
			
			$total['size'] = $totalsize;
			$total['count'] = $totalcount;
			$total['dircount'] = $dircount;
			
			return $total;
		} 

		function file_add_contents($file, $string)
		{
			if (!is_string($file) || !is_string($string)) return false;
			
			$fd = fopen($file, 'a+');
			if ($fd === null) return false;
			fwrite($fd, $string);
			fclose($fd);
			
			return true;
		}

		function copyDirectory($fromDir, $toDir, $chmod = 0755)
		{
			if (!is_string($fromDir) || !is_string($toDir)) return false;
			
			$list =& iFile::getList($fromDir);
			if ($list === false) return false;

			if (empty($list)) return true;

			if (!file_exists($toDir)) {
				if (mkdir($toDir, $chmod) === false) return false;
			}
			
			foreach ($list as $entry) {
				$src = iFile::buildPath(array($fromDir, $entry));
				$dst = iFile::buildPath(array($toDir, $entry));
				if (is_file($src))
				{
					if (copy($src, $dst)) {
						chmod($dst, $chmod);
						touch($dst, filemtime($src));
					}
				} else if (is_dir($src)) {
					if (mkdir($dst)) {
						chmod($dst, $chmod);
					}
					iFile::copyDirectory($src, $dst, $chmod);
				}
			}

			return true;
		}
	}

	require_once('VFS.php');
	
	class iVFS extends VFS
	{
		function & factory($driver, $params = array())
		{
			$obj =& parent::factory($driver, $params);
			return $obj;
		}
		
		function iVFS($driver, $params = array())
		{
			parent::VFS($driver, $params);
		}
		
		function buildPath($parts, $separator = DIRECTORY_SEPARATOR)
		{
			return File::buildPath($parts, $separator);
		}

		function buildPathA($parts, $root, $separator = DIRECTORY_SEPARATOR)
		{
			$path = iVFS::buildPath($parts, $separator);
			return iVFS::relativePathA($path, $root, $separator);
		}

		function relativePath($path, $root, $separator = DIRECTORY_SEPARATOR)
		{
			if ($path === '') return '';
			else return File::relativePath($path, $root, $separator);
		}

		function relativePathA($path, $root, $separator = DIRECTORY_SEPARATOR)
		{
			if ($path === '') return '';

//			if (!strncmp($path, $root, strlen($root))) return $path;
			
			$abs = iVFS::relativePath($path, $root, $separator);
			
			if (substr($abs, 0, 1) == $separator) return $abs;
			else return ($separator . $abs);
		}
		
		function getFileSize($folder, $name)
		{
			clearstatcache();
			return filesize(iVFS::buildPath(array($folder, $name)));
		}
		
		function isEmpty($folder, $name)
		{
			if (!file_exists(iVFS::buildPath(array($folder, $name)))) return '';
			else if (!iVFS::getFileSize($folder, $name)) return '';
			else return iVFS::buildPath(array($folder, $name));
		}

		function & listFiles($folder, $name)
		{
			if (!is_string($folder) || !is_string($name)) return iObject::raiseError(IERROR_PARAMS);
			
			$path = iVFS::buildPath(array($folder, $name));
			$objects = File_Util::listDir($path, FILE_LIST_FILES, FILE_SORT_NAME);
			
			$fileList = array();
			foreach ($objects as $key => $value) {
				$fileList[] = get_object_vars($value);
			}
			unset($objects);

			return $fileList;

		}
		
		function byte2($value, $type = null, $suffix = false)
		{
			if (!is_numeric($value)) return $value;
			
			if (is_null($type)) {
				if ($value < IVFS_KILOBYTE) $type = 'B';
				else if ($value < IVFS_MEGABYTE) $type = 'k';
				else if ($value < IVFS_GIGABYTE) $type = 'M';
				else $type = 'G';
			}
			
			switch (strtolower($type)) {
			case 'b':
			default:
				$type = '';
				break;

			case 'k':
				$value = round($value / IVFS_KILOBYTE, 1);
				$type = 'k';
				break;				

			case 'm':
				$value = round($value / IVFS_MEGABYTE, 1);
				$type = 'M';
				break;

			case 'g':
				$value = round($value / IVFS_GIGABYTE, 1);
				$type = 'G';
				break;				
			}
			
			if ($suffix === true) $value .= ' ' . $type . 'B';
			
			return $value;
		}

		function units2bytes($value)
		{
			$pattern = '/([\d]+)([kKmMgG])/';
			$matches = array();
			
			if (preg_match($pattern, $value, $matches)) {
//				var_dump::display($matches);
				if (empty($matches[2])) $scale = 1;
				else {
					switch (strtolower($matches[2]))
					{
						default:
							$scale = 1;
							break;
							
						case 'k':
							$scale = 1024;
							break;

						case 'm':
							$scale = 1024 * 1024;
							break;

						case 'g':
							$scale = 1024 * 1024 * 1024;
							break;
					}
				}
				return ((int)$matches[1] * (int)$scale);
			} else return iObject::raiseError(null, IERROR_PARAMS);
		}
	}
	
?>
