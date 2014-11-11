<?php

	require_once('user.php');

	class iModule_User extends iModuleDB
	{		
		var $defaultPasswordLength = 8;
		var $defaultGroup = 'users';
		var $defaultType = LIVEUSER_USER_TYPE_ID;

		var $_userTypes = array(
			LIVEUSER_ANONYMOUS_TYPE_ID => 'Gość',
			LIVEUSER_USER_TYPE_ID => 'Użytkownik',
			LIVEUSER_ADMIN_TYPE_ID => 'Administrator',
			LIVEUSER_AREAADMIN_TYPE_ID => 'Administrator Obszaru',
			LIVEUSER_SUPERADMIN_TYPE_ID => 'Super Administrator',
			LIVEUSER_MASTERADMIN_TYPE_ID => 'Administrator Nadrzędny'
		);

		function & onList(&$core, &$args)
		{
			$params = array('order' => 'handle');
			$result =& $core->userAdmin->getUsers($params);
			if ($result === false) return $this->raiseError(null, IERROR_DB_QUERY);
			if (empty($result)) return array();
			
			if (empty($args['return'])) $args['return'] = 'raw';
			
			$list = array();
			
			switch ($args['return']) {
			case 'raw':
			default:
				$list =& $result;
				break;

			case 'options':
			default:
				foreach ($result as $val) $list[$val['perm_user_id']] = $val['handle'];
				break;
			}
			
			return $list;
		}

		function & onExists(&$core, &$args)
    		{
			$this->db->reset();
			$this->db->setTable('liveuser_users');
			$this->db->setSelect('liveuser_users.*, liveuser_perm_users.perm_user_id AS id');
			$this->db->setJoin('liveuser_perm_users', 'liveuser_perm_users.auth_user_id=liveuser_users.authUserId');

			if (!is_numeric($args['id'])) $this->db->setWhere("liveuser_users.handle='{$args['id']}'");
			else $this->db->setWhere("liveuser_perm_users.perm_user_id={$args['id']}");
				
			$result =& $this->db->getAll();
			if ($result === false || empty($result)) return false;
			
			if (!empty($args['all']) && $args['all'] === true) return $result[0];
			else return $result[0]['id'];
		}

		function & onAdd(&$core, &$args)
		{
			if ($this->onExists($core, $params = array('id' => $args['handle']))) return $this->raiseError(null, IERROR_EXISTS);
			
			$params = array(
				'perm_type' => !empty($args['type']) ? $args['type'] : $this->defaultType,
				'handle' => $args['handle'],
				'passwd' => $args['passwd'],
				'is_active' => !empty($args['active']) ? $args['active'] : 0
			);
			$id = $core->userAdmin->addUser($params);
			if ($id === false) return $this->raiseError(null, IERROR_DB_INSERT);

			$params = array(
				'id' => $id,
				'name' => 'email',
				'value' => $args['email']
			);
			$result = $core->call('profile', 'add', $params);
			if ($this->isError($result)) return $result;
			
			return $id;
		}

		function & onEdit(&$core, &$args)
		{		
			$id = $args['id'];
			unset($args['id']);

			if (!empty($args['email'])) {
				$params = array(
					'id' => $id,
					'name' => 'email',
					'value' => $args['email']
				);
				$result = $core->call('profile', 'edit', $params);
				if ($this->isError($result)) return $result;

				unset($args['email']);
			}

			if (empty($args)) return true;
			
			$result =& $core->userAdmin->updateUser($args, $id);
			if ($result === false) return $this->raiseError(null, IERROR_DB_UPDATE);
						
			return true;
		}

		function & onDeleteSingle(&$core, &$args)
		{
			$result = $core->call('profile', 'deleteall', array('id' => $args['id']));
			if ($this->isError($result)) return $result;

			$result =& $core->userAdmin->removeUser($args['id']);
			if ($result === false) return $this->raiseError(null, IERROR_DB_DELETE);
			
			return true;
		}

    		function & onListForm(&$core, &$args)
    		{
    			$users =& $this->onList($core, $params = array());
    			if ($this->isError($users)) return $users;
			
			foreach ($users as $key => $value) {
				if (strftime('%Y', strtotime($value['lastlogin'])) == '1970') unset($users[$key]['lastlogin']);
			}

			$core->smarty->assign_by_ref('users', $users);
			$core->smarty->assign_by_ref('types', $this->_userTypes);
			
			return true;
		}

    		function & onAddForm(&$core, &$args)
    		{
			$core->smarty->assign('action', iCore::URL($this->name, 'add'));
			$core->smarty->assign_by_ref('types', $this->_userTypes);
			
			return true;
    		}

    		function & onEditForm(&$core, &$args)
    		{
			$user =& $this->onExists($core, $params = array('id' => $args['id'], 'all' => true));
			if (!$user) return $this->raiseError(null, IERROR_NOT_FOUND);
			
			$profile =& $core->call('profile', 'getall', $params = array('id' => $args['id']));
			if ($this->isError($profile)) return $profile;

			$user =& array_merge($user, $profile);

			$core->smarty->assign('action', iCore::URL($this->name, 'edit', array('id' => $args['id'])));
			$core->smarty->assign_by_ref('types', $this->_userTypes);
			$core->smarty->assign_by_ref('user', $user);
			
			return true;
    		}
		
    		function & onRegisterForm(&$core, &$args)
    		{
			$core->smarty->assign('action', iCore::URL($this->name, 'register'));
    		}

    		function & onRegister(&$core, &$args)
    		{
			if (empty($args['agree'])) 
				return $this->raiseError('Do założenia konta niezbędna jest zgoda na warunki przedstawione w Polityce Prywatności');

			if (strcmp($args['passwd'], $args['passwd_confirm']))
				return $this->raiseError('Podane hasła nie zgadzają się');

			if (!empty($args['email']) && !empty($args['email_confirm']) && strcmp($args['email'], $args['email_confirm']))
				return $this->raiseError('Podane adresy e-mail nie zgadzają się');

			$args['type'] = LIVEUSER_USER_TYPE_ID;
//			$args['active'] = 1;

			$id = $core->call('user', 'add', $args);
			if ($this->isError($id)) return $this->raiseError($id);
			
			return $id;
	   	 }

	    	function & onRules(&$core, &$args)
	    	{
	    	}

	    	function & onLoginForm(&$core, &$args)
	    	{
			$core->smarty->assign('action', iCore::URL($this->name, 'login'));
		}

		function & login(&$core, &$args)
		{
			if (!empty($args['remember'])) $remember = true;
			else $remember = false;

			if (!$core->user->login($args['login'], $args['password'], $remember))
				return $this->raiseError('Logowanie nieudane.<br/>Sprawdź, czy Twój login i hasło są poprawne.');

			if (!empty($core->user->_rightList)) unset($core->user->_rightList);
			$options = array('naming' => LIVEUSER_SECTION_AREA);
			$core->user->_rightList =& $core->userAdmin->perm->outputRightsConstants('array', $options);

			foreach ($core->user->_rightList as $key => $val) {
				if (!$core->user->checkRight($val)) unset($core->user->_rightList[$key]);
			}
			
			if (!empty($core->user->_profile)) unset($core->user->_profile);
			$core->user->_profile =& $core->call('profile', 'getall', array('id' => $core->user->getProperty('perm_user_id')));
			
			// TODO: make it faster
			$core->user->_freeze();
			
			return true;
		}

		function & guestLogin(&$core)
		{
			$params = array(
				'login' => 'admin',
				'password' => 'admin',
				'remember' => false
			);

			return $this->login($core, $params);
		}

		function & onLogin(&$core, &$args)
		{
			$result = $this->login($core, $args);
			if ($this->isError($result)) {
				$guestResult = $this->guestLogin($core);
				if ($this->isError($guestResult)) return $this->raiseError($guestResult);
				else return $this->raiseError($result);
			}

			$core->redirect();
			
			return true;
		}

		function & onGuestLogin(&$core, &$args)
		{
			return $this->guestLogin($core);
		}

		function & onLogout(&$core, &$args)
		{
			$core->user->logout();
			$this->guestLogin($core);
			$core->redirect();

			return true;
		}

		function & onActivate(&$core, &$args)
		{
			if (empty($args['id']) && empty($args['hash'])) return $this->raiseError(null, IERROR_PARAMS);
			
			if (!empty($args['id']) && is_numeric($args['id'])) $id = (int) $args['id'];
			else {
				$this->db->reset();
				$this->db->setTable('liveuser_users');
				$this->db->setSelect('liveuser_perm_users.perm_user_id AS id');
				$this->db->setJoin('liveuser_perm_users', 'liveuser_perm_users.auth_user_id = liveuser_users.authUserId');

				if (!empty($args['hash'])) $this->db->setWhere("MD5(CONVERT(handle USING latin2)) = '{$args['hash']}'");
				else $this->db->setWhere("handle='{$args['id']}'");

				$result =& $this->db->getAll();
				if ($result === false) return $this->raiseError('Aktywacja nieudana. Sprawdź poprawność odnośnika.<br/>W razie problemów skontaktuj się z administratorem pod adresem admin@egie.pl');

				$id = (int) $result[0]['id'];
			}
			
			$result = $core->userAdmin->updateUser(array('is_active' => 1), $id);
			if ($result === false) return $this->raiseError(null, IERROR_DB_QUERY);
						
			return true;
		}

	   	 function & onResetPassword(&$core, &$args)
	    	{
			if ($this->userExists($args['id']) === false)
				return $this->raiseError('Użytkownik o id=' . $args['id'] . ' nie istnieje');				

			require_once('Text/Password.php');
			
			$data = array('passwd' => Text_Password::create($this->defaultPasswordLength, 'pronounceable'));
			$result =& $core->userAdmin->updateUser($data, $args['id']);
			if (!$result) return $this->raiseError(implode($core->userAdmin->getErrors()));
			
			return $data['passwd'];
		}
	}

?>
