<?php

	class iModule_UserProfile extends iModule
	{
		var $companyName = 'eGmina, Infrastruktura, Energetyka Sp. z o.o.';
		
		function & getFullProfile($id)
		{
			$core =& $this->getCore();
			
			$prefs =& $core->call('profile', 'getall', array('id' => $id));
			if ($this->isError($prefs)) return $prefs;

			$user =& $core->call('user', 'exists', array('id' => $id, 'all' => true));
			if ($this->isError($user)) return $user;

			unset($user['passwd']);

			return array_merge($user, $prefs);
		}

		function & onGet(&$core, &$args)
		{
			return $this->getFullProfile($args['id']);
		}

		function & onEditForm(&$core, &$args)
		{
			if ($args['id'] != $core->user->getProperty('perm_user_id') && !$core->checkRightByName($this->name, 'edit_all'))
				die($core->run('sysmsg', 'security', array('msg' => 'Nie posiadasz uprawnień do edycji tego profilu')));

			$profile =& $this->getFullProfile($args['id']);
			if ($this->isError($profile)) return $profile;

			$roles =& $core->call('group', 'getroles');
			if ($this->isError($roles)) return $roles;

			$userGroups = $core->call('group', 'getusergroups', array('id' => $args['id']));
			if ($this->isError($userGroups)) return $userGroups;

			$core->smarty->assign_by_ref('user_groups', $userGroups);
			$core->smarty->assign_by_ref('roles', $roles);
			$core->smarty->assign_by_ref('prefs', $profile);
				
			return true;
		}

		function & onEdit(&$core, &$args)
		{
			if ($args['id'] != $core->user->getProperty('perm_user_id') && !$core->checkRightByName($this->name, 'edit_all'))
				die($core->run('sysmsg', 'security', array('msg' => 'Nie posiadasz uprawnień do edycji tego profilu')));
		
			if (!empty($args['passwd'])) {
				if (empty($args['passwd_confirm']) || $args['passwd_confirm'] != $args['passwd'])
					return $this->raiseError('Podane hasła nie są identyczne. Sprawdź pola.');
				$result = $core->call('user', 'edit', $args);
				if ($this->isError($result)) return $this->raiseError($result);
				unset($args['passwd'], $args['passwd_confirm']);
			}

			$id = $args['id'];
			unset($args['id']);

			// "Direct" profile values, such as name, lastname, address etc.
			
			if (!empty($args)) {
				$result =& $core->call('profile', 'editmultiple', array('id' => $id, 'prefs' => $args));
				if ($this->isError($result)) return $this->raiseError($result);
			}
			
			$core->redirect(iCore::URL($this->name, 'editform', array('id' => $id), null, false));
			
			return true;
		}

		function & onRegister(&$core, &$args)
		{
			$id = $core->call('user', 'register', $args);
			if ($this->isError($id)) return $this->raiseError($id);

			$group = $core->call('group', 'exists', array('id' => 'Guest', 'all' => true));
			if ($this->isError($group)) return $this->raiseError($group);

			$result = $core->call('group', 'addgroupuser', array('gid' => $group['group_id'], 'id' => $id));
			if ($this->isError($result)) return $this->raiseError($result);

			$group = $core->call('group', 'exists', array('id' => 'User', 'all' => true));
			if ($this->isError($group)) return $this->raiseError($group);

			$result = $core->call('group', 'addgroupuser', array('gid' => $group['group_id'], 'id' => $id));
			if ($this->isError($result)) return $this->raiseError($result);

			$args['confirm_url'] = 'http://www.egie.pl/' . 
				iCore::URL($this->name, 'activate', array('hash' => md5($args['handle'])), null, false);
			
			$params = array(
				'type' => 'admin',
				'template' => 'registration_confirm',
				'address' => $args['email'],
				'subject' => '[egie.pl] Rejestracja konta',
				'vars' => $args
			);
			$result = $core->call('mailing', 'sendPersonalizedTemplate', $params);
			if ($this->isError($result)) return $this->raiseError($result); 
			
			$core->redirect($core->URL('user', 'registerconfirm', array(), 'xhtml', false));

			return true;
		}

		function & onActivate(&$core, &$args)
		{
			$result = $core->call('user', 'activate', $args);
			if ($this->isError($result)) return $this->raiseError($result);

			if (!empty($args['message'])) $msg = $args['message'];
			else $msg = 'Konto zostało aktywowane. Możesz się teraz zalogować.<br/>Aby to uczynić, przejdź na stronę główną, a następnie wprowadź wybrane wcześniej login i hasło.';

			die($core->run('sysmsg', 'confirm', array('msg' => $msg)));
		
			return true;
		}

		function & onResetPassword(&$core, &$args)
		{
			if (!is_numeric($args['id'])) {
				$data =& $core->call('user', 'exists', array('id' => $args['id'], 'all' => true));
				if (!$data) return $this->raiseError("Użytkownik o loginie '{$args['id']}' nie istnieje");
				$id = $data['id'];
			} else $id = $args['id'];
		
			$profile =& $this->getFullProfile($id);
			if ($this->isError($profile)) return $this->raiseError($profile);
			
			$pass = $core->call('user', 'resetpassword', array('id' => $id));
			if ($this->isError($pass)) return $this->raiseError($pass);
			
			$profile['passwd'] = $pass;

			$params = array(
				'type' => 'admin',
				'template' => 'password_reset',
				'address' => $profile['email'],
				'subject' => '[egie.pl] Odzyskiwanie hasła',
				'vars' => &$profile
			);
			$result = $core->call('mailing', 'sendPersonalizedTemplate', $params);
			if ($this->isError($result)) return $this->raiseError($result); 
			
			$msg = "Nowe hasło zostało wygenerowane i wysłane na adres e-mail<br/><b>{$profile['email']}</b>.";
			die($core->run('sysmsg', 'confirm', array('msg' => $msg)));
		
			return true;
		}

	} 

?>
