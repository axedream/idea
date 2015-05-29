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
		'modal_box'		=>	false
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
		'modal_box'		=>	false
		
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
		'modal_box'		=>	'login/modalLoginForm'
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
		'modal_box'		=>	false
		
	],  
	);