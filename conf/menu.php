<?php
return array (

'main' =>
	[
		'controller'	=>	'main',
		'action'		=>	'index',
		'id'			=>	false,
		'group'			=>	'left',
		'name'			=>	'Главная',
		'glyphicon'		=>	'glyphicon-home',
		'modal'			=>	false,
		'modal_box'		=>	false,
		'modal_url'		=>	false,
	],
'about' =>
	[
		'controller'	=>	'about',
		'action'		=>	'index',
		'id'			=>	false,
		'group'			=>	'left',
		'name'			=>	'Обратная связь',
		'glyphicon'		=>	'glyphicon-eye-open',
		'modal'			=>	false,
		'modal_box'		=>	false,
		'modal_url'		=>	false,
		
	],
'register' =>
	[
		'controller'	=>	'register',
		'action'		=>	'request',
		'id'			=>	'useradd',
		'group'			=>	'right',
		'name'			=>	'Регистрация',
		'glyphicon'		=>	'glyphicon-log-in',
		'modal'			=>	'data-toggle="modal" data-target="#modalRegisterForm"',
		'modal_box'		=>	'login/modalRegisterForm',
		'modal_url'		=>	'login/request/register',
	],	
'login' =>
	[
		'controller'	=>	'login',
		'action'		=>	'login',
		'id'			=>	false,
		'group'			=>	'right',
		'name'			=>	'Войти',
		'glyphicon'		=>	'glyphicon-log-in',
		'modal'			=>	'data-toggle="modal" data-target="#modalLogin"',
		'modal_box'		=>	'login/modalLoginForm',
		'modal_url'		=>	'login/login',
	],	
'logout'=>
	[
		'controller'	=>	'login',
		'action'		=>	'logout',
		'id'			=>	false,
		'group'			=>	'right',
		'name'			=>	'Выйти',
		'glyphicon'		=>	'glyphicon-log-out',
		'modal'			=>	false,
		'modal_box'		=>	false,
		'modal_url'		=>	false,
		
	],  
	);