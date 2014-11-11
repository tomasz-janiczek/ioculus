<?php	class iModule_Install extends iModule
	{	
		function & onStep1(&$core, &$args)
		{
			$core->Message("<b>Welcome to iOculus sample application setup!</b><br/><br/>
						      This module will install an 'out-of-the-box' iOculus sample application on your system, by setting up the database and
						      creating all the needed configuration files.<br/><br/>
						      Please note, that not completing this process doesn't mean, that iOculus will be unusable, but rather that you will have to do all the work
						      manually.<br/><br/>", iCore::URL($this->name, 'step2'), 'Info');
		
			return true;
		}

		function & onStep2(&$core, &$args)
		{
			$core->smarty->assign('action', iCore::URL($this->name, 'step3'));
		
			return true;
		}

		function & onStep3(&$core, &$args)
		{
			require_once('MDB2.php');
			
			$dsn = "mysql://{$args['username']}:{$args['password']}@{$args['hostspec']}/{$args['database']}";
			$db =& MDB2::singleton($dsn);
			if (PEAR::isError($db)) return $this->raiseError($db);
			
			$sql = file_get_contents($this->uploadDir . '/structure.sql');
			$sql_arr =  preg_split('/;[\n\r]+/', $sql);

			foreach($sql_arr as $line) {
				if (empty($line)) continue;

				$result = $db->exec($line);
				if (PEAR::isError($result)) return $this->raiseError($result);
			}

			require_once('PHP/Compat.php');
			PHP_Compat::loadFunction('file_put_contents');
			
			file_put_contents('conf/db.php', "<?php\n\t\$config = array('dsn' => '{$dsn}');\n?>");

			$core->Message("<b>Installation complete</b><br/><br/>The database has been filled with sample contents</b>", 0, $core->defaultURL());
			
			return true;
		}
	} 

?>
