<?php

	define('ICORE_NAME', 'icore');
	define('ISESSION_NAME', 'ioculus');
	define('IMODE_DEFAULT', 'xhtml');
	
	// Setup error reporting

	@ini_set('display_errors', 1);
	@error_reporting(E_ALL ^ E_NOTICE);

	// Other options
	@ini_set('magic_quotes_gpc', 0);
	@ini_set('magic_quotes_runtime', 0);

	// Get the database DSN
	@include_once('db.php');
	
	if (!isset($config)) $config = array();

	$config['root'] = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..');

	if ($config['root'] == DIRECTORY_SEPARATOR) $root = '';
	else $root = $config['root'];

	$config['include'] = array();
	$config['include']['root'] = $root . DIRECTORY_SEPARATOR . 'include';
	$config['include']['pear'] = $config['include']['root'] . DIRECTORY_SEPARATOR . 'pear';

	$config['dir'] = array();
	$config['dir']['cache'] = $root . DIRECTORY_SEPARATOR . 'cache';
	$config['dir']['www'] = $root . DIRECTORY_SEPARATOR . 'www';
	$config['dir']['smarty'] = $root . DIRECTORY_SEPARATOR . 'smarty';
	$config['dir']['modules'] = $config['dir']['www'] . DIRECTORY_SEPARATOR . 'modules';
	$config['dir']['templates'] = $config['dir']['www'] . DIRECTORY_SEPARATOR . 'templates';
	$config['dir']['schemes'] = $config['dir']['templates'] . DIRECTORY_SEPARATOR . 'schemes';
	
	$config['domain'] = $_SERVER['HTTP_HOST'];

	if (PHP_OS == 'WINNT') {
		$c = ';';
		$config['os'] = 'win';
	} else {
		$c = ':';
		$config['os'] = 'unix';
	}
	
	ini_set("include_path", getcwd());

	if (is_array($config['include'])) {
		foreach ($config['include'] as $value) ini_set("include_path", ini_get("include_path") . $c . $value);
	} else ini_set("include_path", ini_get("include_path") . $c . $config['include']);

	/* Cookies.
	 * For testing and developement purposes (some people use local domain names like 'foobar' on LAMP/WAMP) - detect if we run
	 * on a normal Internet domain, or not.
	 */

	if (strpos($config['domain'], '.')) $cookie_domain = ".{$config['domain']}";
	else $cookie_domain = "";
	
	session_set_cookie_params(0, '/', $cookie_domain);

	// We always will use PEAR
	
	require_once('PEAR.php');

	ini_set('unserialize_callback_func', 'iLoadClass');

	function iLoadClass($class)
	{	
		if (strpos($class, "i") === 0) {
			global $config;
			
			$file = $config['include']['root'] . DIRECTORY_SEPARATOR . substr($class, 1) . '.php';

			if (file_exists($file)) {
				require_once($file);
				return;
			} else {
				$file = basename($file);
				die("Tried to autoload the class '{$class}' from file '{$file}', but file doesn't exist. Giving up.");
			}
		} else die("Tried to autoload the class '{$class}', but can't figure out it's source file. Giving up.");
	}

?>
