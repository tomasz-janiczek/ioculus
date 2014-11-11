<?php

	define('ILIVEUSER_VAR', 'iLiveUser');

	class iUserFactory
	{
		var $config = array (
			'autoInit'		=> true,
			'debug'		=> true,
			'session' => array(
			    'name'		=> ISESSION_NAME,
			    'varname'	=> ILIVEUSER_VAR,
			    'force_start'	=> false
			),
			'login' => array('force' => false),
			'logout' => array('destroy' => false),
	        	'cookie' => array(
	        		'name'	=> 'loginInfo',
	        		'lifetime'	=> 30,
	        		'path'	=> '/',
	        		'domain'	=> '',
	        		'secure'	=> false,
	        		'secret'	=> 'ioculus'
	        	),
			'authContainers' => array(
				'DB_Local' => array(
					'type'				=> 'MDB2',
					'loginTimeout'			=> 0,
					'expireTime'			=> 10800,
					'idleTime'				=> 1800,
					'allowDuplicateHandles'	=> false,
					'allowEmptyPasswords'	=> false,
					'updateLastLogin'		=> true,
					'storage' => array(
						'prefix'	=> 'liveuser_',
	            				'alias' => array(
							'auth_user_id'		=> 'authUserId',
							'lastlogin'			=> 'lastLogin',
							'is_active'			=> 'isActive',
							'owner_user_id'	=> 'owner_user_id',
							'owner_group_id'	=> 'owner_group_id',
				                ),
				                'fields' => array(
							'lastlogin'			=> 'timestamp',
							'is_active'			=> 'boolean',
							'owner_user_id'	=> 'integer',
							'owner_group_id'	=> 'integer',
				                ),
				                'tables' => array(
				                    'users' => array(
				                        'fields' => array(
								'lastlogin'			=> false,
								'is_active'			=> null,
								'owner_user_id'	=> null,
								'owner_group_id'	=> null,
				                        ),
				                    ),
				                ),
					),
				),
			),
			
			'permContainer' => array(
				'type' => 'Medium',
				'storage' => array(
					'MDB2' => array(
						'prefix'	=> 'liveuser_',
						'alias'	=> array(
							'group_description'	=> 'group_description',
							'right_description'	=> 'right_description',
							'area_description' 	=> 'area_description',
						),
						'fields' => array(
							'group_description'	=> 'text',
							'right_description'	=> 'text',
							'area_description'	=> 'text'
						),
						'tables' => array(
							'groups' => array(
								'fields' => array(
									'group_description' => false
								),
							),
							'rights' => array(
								'fields' => array(
									'right_description' => false
								),							
							),
							'areas' => array(
								'fields' => array(
									'area_description' => false
								),							
							),
						),
					),
				),
			), 
		);

		function & factory($type, &$db)
		{
			global $config;
			
			$vars =& get_class_vars(__CLASS__);
			$conf =& $vars['config'];
			
			$conf['cookie']['domain'] = $config['domain'];
			$conf['authContainers']['DB_Local']['storage']['dbc'] =& $db;
			$conf['permContainer']['storage']['MDB2']['dbc'] =& $db;
			
			if ($type === 'admin') {
				require_once('LiveUser/Admin.php');
				
				$obj =& LiveUser_Admin::singleton($conf);
				$obj->init();
			} else {
				require_once('user.php');
				
				$obj =& iUser::factory($conf);
			}

			return $obj;
		}
	}

?>