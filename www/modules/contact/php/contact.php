<?php

	class iModule_Contact extends iModule
	{
		var $defaultMail = 'kontakt@egie.pl';
		
		function & onShowForm(&$core, &$args)
		{
			$article =& $core->call('article', 'exists', $params = array('id' => 84, 'all' => true));
			$core->smarty->assign_by_ref('article', $article);
		
			return true;
		}

		function & onSend(&$core, &$args)
		{
			if (empty($args['contact_id'])) $address = $this->defaultMail;
			else {
				$prefs =& $core->call('profile', 'getall', array('id' => $args['contact_id']));
				if ($this->isError($prefs)) return $prefs;

				if (empty($prefs['email'])) $address = $this->defaultMail;
				else $address = $prefs['email'];
			}
			
			if (!empty($prefs)) $args['profile'] =& $prefs;

			$params = array(
				'template' => 'contact_mail',
				'address' => $address,
				'subject' => '[Formularz kontaktowy] Nowa wiadomość',
				'vars' => $args
			);
			if (!empty($args['email'])) {
				$params['reply_to'] = $args['email'];
				$params['reply_to_name'] = $args['fullname'];
			}
			if (!empty($args['vcard'])) {
				$params['attachments'] = array();
				$params['attachments']['vcard.vcf'] = array('path' => $args['vcard']['tmp_name']);
			}
			if (!empty($args['attach'])) {
				if (!isset($params['attachments'])) $params['attachments'] = array();
				$name = $args['attach']['name'];
				$params['attachments'][$name] = array('path' => $args['attach']['tmp_name']);
			}
			
			$result = $core->call('mailing', 'sendtemplate', $params);
			if ($this->isError($result)) return $result;

			die($core->run('sysmsg', 'info', array('msg' => 'Twoja wiadomość została wysłana.<br/>Dziękujemy.')));
			
			return true;
		}
		
		function & onDownloadVCard(&$core, &$args)
		{
			$vcard =& $core->call('vcard', 'buildforuser', array('id' => $args['id']));
			if ($this->isError($vcard)) return $vcard;

			require_once('HTTP/Download.php');
			
			$dl =& new HTTP_Download();	
			$dl->setData($vcard);
			$dl->setLastModified(time());
			$dl->setContentType('text/x-vcard');
			$dl->setContentDisposition(HTTP_DOWNLOAD_ATTACHMENT, 'vcard.vcf');
			$dl->send();
			
			return true;
		}
	}

?>
