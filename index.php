<?php

	require_once('conf/config.php');
	require_once('core.php');

	$core =& iSession::start();

	$module = (isset($_GET['m']) && !empty($_GET['m'])) ? $_GET['m'] : 'news';
	$action = (isset($_GET['act']) && !empty($_GET['act'])) ? $_GET['act'] : '';
	$mode = (isset($_GET['mode']) && !empty($_GET['mode'])) ? $_GET['mode'] : IMODE_DEFAULT;
	$content = '';

	$mode = strtolower($mode);
	echo $core->moduleRun($module, $action, $_GET, $_POST, $mode, true);

	if ($mode === 'xhtml') {
		$info = array('time' => 'unknown');
		if ($config['os'] == 'unix') $info['mem'] = memory_get_usage() / 1024;
		else $info['mem'] = 'unknown';
		
		echo '<!--';
		printf("User ID: %d | Cache address: [%s] | Page generated in %2.4f | Memory used: %2.1f kB", $core->user ? $core->user->getProperty('perm_user_id') : 0, $core->cacheAddress, $info['time'], $info['mem']);
		echo '-->';
	}

?>
