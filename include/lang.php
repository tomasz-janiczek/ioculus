<?php

	require_once('object.php');

	class iLang extends iObject
	{
		function removePLChars($name, $charset = "UTF-8")
		{
			$name = iconv($charset, "ISO-8859-2", $name);
			$srcChars = iconv($charset, "ISO-8859-2", "ĄĆĘŁŃÓŚŻŹąćęłńóśżź");
			$dstChars = iconv($charset, "ISO-8859-2", "ACELNOSZZacelnoszz");
			$name = strtr($name, $srcChars, $dstChars);
			return iconv("ISO-8859-2", $charset, $name);
		}

		function normalizeName($name, $length = 32)
		{
			$info = pathinfo($name);			
			$name = mb_strtolower(iLang::removePLChars($info['basename']));
			$name = wordwrap($name, $length, "\n");
			$lines = explode("\n", $name);
			return (strtr($lines[0], " ", "_"));
		}
	}

?>
