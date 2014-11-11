<?php

	class iModule_VCard extends iModule
	{	
		function & onBuild(&$core, &$args)
		{
			require_once('Contact_Vcard_Build.php');
			
			$profile =& $args['data'];
			$vcard =& new Contact_Vcard_Build();

			$vcard->setName($profile['lastname'], $profile['name'], '', '', '');
			$vcard->setFormattedName();

			$vcard->addEmail($profile['email']);
			$vcard->addParam('TYPE', 'WORK');
			$vcard->addParam('TYPE', 'PREF');

			if (!empty($profile['company'])) $vcard->addOrganization($profile['company']);
			if (!empty($profile['position'])) $vcard->setRole($profile['position']);
			
			if (!empty($profile['phone'])) {
				$vcard->addTelephone($profile['phone']);
				$vcard->addParam('TYPE', 'WORK');
				$vcard->addParam('TYPE', 'PREF');
			}
			
			$text =& $vcard->fetch();
			unset($vcard);
			
			return $text;
		}

		function & onBuildForUser(&$core, &$args)
		{
			$profile =& $core->call('userprofile', 'get', array('id' => $args['id']));
			if ($this->isError($profile)) return $this->raiseError($profile);
			
			$params = array('data' => $profile);
			return $this->onBuild($msg, $core, $params);
		}
	} 

?>
