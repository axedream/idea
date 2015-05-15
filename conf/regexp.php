<?php
return array (
	'uri'	=> [
		'controller' 	=> '/^[a-zA-Z0-9+_\-]{2,20}$/',
		'action' 		=> '/^[a-zA-Z0-9+_\-]{2,20}$/',
		'id' 			=> '/^[a-zA-Z0-9+_\-\:\?\=]{1,40}$/'
	],
	'user' => [
		'login' 		=> '/^[a-z0-9_-]{3,16}$/',
		'password'		=> '/^[a-z0-9_-]{3,18}$/',
	]
);