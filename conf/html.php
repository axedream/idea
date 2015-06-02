<?php
return array (
	'title' 		=>	'IDEa - некий сайт',
	'keywords'		=>	'Ключевые слова',
	'description'	=>	'Общий контекст',
	'css'			=> 
			[
			PLUG.'bootstrap/css/bootstrap.min.css',
			PLUG.'css/style.css',
			PLUG.'css/header.css',
			PLUG.'css/menu.css',
			PLUG.'css/footer.css',
			PLUG.'css/help.css',
 			PLUG.'css/login.css'
			],
	'js'			=>
			[
			PLUG.'jquery/jquery-2.1.4.js',
			PLUG.'bootstrap/js/bootstrap.min.js',
			PLUG.'js/center.js',
			PLUG.'js/higher.js'
			],
	'modules'		=>	include CONF.'modules.php',
	'menu'			=>	include CONF.'menu.php'
	);