<?php
return array (
	'name'					=>	'idEa',
	'encode'				=>	'utf-8',
	'cookietime'			=>	3600,
	'version' 				=> '0.0.2015.05',
	'default_controller' 	=> 'Main',
	'default_action' 		=> 'Index',
	'default_id'			=> '',
	'layouts'				=> 'layouts/main',
	'db'					=>	include CONF.'db.php',
	'regexp'				=>	include CONF.'regexp.php',
	'html'					=>	include CONF.'attr.php'
);