<?php
return array (
	'title' 		=>	'idEa',
	'keywords'		=>	'Ключевые слова',
	'description'	=>	'Общий контекст',
	'css'			=> 
			[
			'0'		=>	PLUG.'bootstrap/css/bootstrap.min.css',
			'1'		=>	PLUG.'css/style.css'
			],
	'js'		=>
			[
			'0'		=>	PLUG.'jquery/jquery-2.1.4.js',
			'1'		=>	PLUG.'bootstrap/js/bootstrap.min.js'
			],
	'modules'		=>	include CONF.'modules.php'
	);