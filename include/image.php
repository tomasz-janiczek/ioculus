<?php

	require_once('object.php');

	class iImage extends iObject
	{
		var $_path = '';
		var $_scale = false;
		var $_minWidth = 0;
		var $_minHeight = 0;
		var $_maxWidth = 0;
		var $_maxHeight = 0;

		function & factory($path)
		{
			$obj =& new iImage($path);			
			return $obj;
		}

		function iImage($path)
		{
			$this->_path = $path;
		}

		function & _loadImage($file)
		{
			if (empty($file) || !is_string($file)) return $this->raiseError(null, IERROR_PARAMS);
			
			require_once('Image/Transform.php');
			
			$img =& Image_Transform::factory('IM');
			if (PEAR::isError($img)) return $this->raiseError($img->getMessage());
			$result = $img->load($file);
			if (PEAR::isError($img)) return $this->raiseError($result->getMessage());
			
			return $img;
		}

		function _freeImage(&$img)
		{
			if (empty($img) || !is_object($img)) return $this->raiseError(null, IERROR_PARAMS);
			
			$img->free();
			unset($img);
			
			return true;
		}

		function doScale($value)
		{
			if (!is_bool($value)) return $this->raiseError(null, IERROR_PARAMS);

			$this->_scale = $value;
		}
		
		function setSize($minW = 0, $minH = 0, $maxW = 0, $maxH = 0)
		{
			if (!is_numeric($minW) || !is_numeric($minH) || !is_numeric($maxW) || !is_numeric($maxH))
				return $this->raiseError(null, IERROR_PARAMS);
				
			$this->_minWidth = $minW;
			$this->_minHeight = $minH;
			$this->_maxWidth = $maxW;
			$this->_maxHeight = $maxH;
			
			return true;
		}

		function checkSize()
		{
			$file = $this->_path;

			if (empty($file) || !is_string($file)) return $this->raiseError(null, IERROR_PARAMS);
			if ($this->_minWidth === 0 && $this->_maxWidth === 0 &&
			    $this->_minHeight === 0 && $this->_maxHeight === 0) return true;

			$img =& $this->_loadImage($file);
			if ($this->isError($img)) return $img;			
			$width = $img->img_x;
			$height = $img->img_y;
			$this->_freeImage($img);
			
			if ($this->_minWidth > 0 && $width < $this->_minWidth) return false;
			if ($this->_minHeight > 0 && $height < $this->_minHeight) return false;
			if ($this->_maxWidth > 0 && $width > $this->_maxWidth) return false;
			if ($this->_maxHeight > 0 && $height > $this->_maxHeight) return false;

			return true;
		}

		function _scaleImageSize($file, $maxSize, $newFilename = '')
		{
			if (empty($file) || !is_string($file) || empty($maxSize) || !is_numeric($maxSize))
				return $this->raiseError(null, IERROR_PARAMS);

			$img =& $this->_loadImage($file);
			if ($this->isError($img)) return $img;			

			$max = 0;
			if ($img->img_x > $img->img_y) $max = $img->img_x;
			else $max = $img->img_y;
			
			if ($max == 0) return $this->raiseError(OCULUS_ERROR);
			
			$result = $img->scaleByFactor($maxSize / $max);
			if (PEAR::isError($result)) {
				$this->_freeImage($img);
				return $this->raiseError($result->getMessage());
			}
			
			if (!empty($newFilename) && is_string($newFilename)) $file = $newFilename;
			
			$result = $img->save($file, $img->type);
			$this->_freeImage($img);
			
			if (PEAR::isError($result)) return $this->raiseError($result->getMessage());
			else return $file;
		}
		
		function scale($dest = '')
		{
			$file = $this->_path;

			if ($this->_maxWidth > 0 || $this->_maxHeight > 0) {
				if ($this->_maxWidth > $this->_maxHeight) $max = $this->_maxWidth;
				else $max = $this->_maxHeight;

				$newFile = $this->_scaleImageSize($file, $max, $dest);
				if ($this->isError($newFile)) return $newFile;
				
				$file = $newFile;
			}
			
			return $file;
		}
	}

?>
