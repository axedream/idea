<?php
return array (
	'title' 		=>	'XIAG test task',
	'keywords'		=>	'URL shortener 	Long URL Short URL',
	'description'	=>	'transformation of links',
	'css'			=> 
			[
			PLUG.'css/style.css'
			],
	'js'			=>
			[
			PLUG.'jquery/jquery-2.1.4.js'
			],
	'modules'		=>	include CONF.'modules.php',
	'menu'			=>	include CONF.'menu.php'
	);