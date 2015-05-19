<?php
return array (
	'title' 		=>	'idEa',
	'keywords'		=>	'Ключевые слова',
	'description'	=>	'Общий контекст',
	'css'			=> 
			[
			PLUG.'bootstrap/css/bootstrap.min.css',
			PLUG.'css/style.css',
			PLUG.'css/header.css',
			PLUG.'css/menu.css'			
			],
	'js'			=>
			[
			PLUG.'jquery/jquery-2.1.4.js',
			PLUG.'bootstrap/js/bootstrap.min.js',
			PLUG.'js/center.js'
			],
	'modules'		=>	include CONF.'modules.php',
	'menu'			=>	include CONF.'menu.php'
	);