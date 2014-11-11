<?php

	class iModule_SysMsg extends iModule
	{
		var $_validTypes = array('error', 'info', 'confirm', 'security');
		
		function assign(&$core, &$args, $type = 'info')
		{
			if (empty($args['url'])) $args['url'] = $core->defaultURL();
			$core->smarty->assign_array($args);
			$core->smarty->assign('icon', $type);
			
			return true;
		}
		
		function & onInfo(&$core, &$args)
		{
			return $this->assign($core, $args, 'info');
		}

		function & onError(&$core, &$args)
		{
			return $this->assign($core, $args, 'error');
		}

		function & onConfirm(&$core, &$args)
		{
			return $this->assign($core, $args, 'confirm');
		}

		function & onSecurity(&$core, &$args)
		{
			return $this->assign($core, $args, 'security');
		}
	}

?>
