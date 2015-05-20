<?php
return array (
	'main'	=>
			[
				'action'		=>	'index',
				'id'			=>	false,
				'name'			=>	'Главная',
				'group'			=>	'base',
				'glyphicon'		=>	'glyphicon-home'
			],
			
	'about'	=>
			[
				'action'		=>	'index',
				'id'			=>	false,
				'name'			=>	'Обратная связь',
				'group'			=>	'base',
				'glyphicon'		=>	'glyphicon-eye-open'
			],

	'register'	=>
			[
				'controller'	=>	'login',
				'action'		=>	'register',
				'id'			=>	false,
				'name'			=>	'Регистрация',
				'group'			=>	'register',
				'glyphicon'		=>	'glyphicon-registration-mark'
			],
			
	'login'	=>
			[
				'action'		=>	'login',
				'id'			=>	false,
				'name'			=>	'Войти',
				'group'			=>	'login',
				'glyphicon'		=>	'glyphicon-log-in',
				'modal'			=>	'data-toggle="modal" data-target="#myModal"',
				'modal_box'		=>	'login/modalLoginForm'
			],

	'logout'	=>
			[
				'action'		=>	'#',
				'id'			=>	'logout',
				'name'			=>	'Выйти',
				'group'			=>	'logout',
				'glyphicon'		=>	'glyphicon-log-out'
			]
			
	);