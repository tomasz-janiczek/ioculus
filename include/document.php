<?php

	require_once('object.php');
	
	define('IDOCUMENT_CHARSET_DEFAULT', 'utf-8');
	define('IDOCUMENT_TITLE_DEFAULT', 'iOculus');
	define('IDOCUMENT_DOCTYPE_DEFAULT',
//		 'html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"');
		'html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"'
	);
	
	class iDocument extends iObject
	{
		var $charset = IDOCUMENT_CHARSET_DEFAULT;
		var $title = IDOCUMENT_TITLE_DEFAULT;
		var $doctype = IDOCUMENT_DOCTYPE_DEFAULT;
		
		function & factory()
		{
			$obj =& new iDocument();
			return $obj;
		}
	}

?>
