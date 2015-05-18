<?php
function base_autoload($class_name) {
	$file = CORECLASSBASE . 'base'.$class_name.'.php';
	if( file_exists($file) == false ) return false;
	require_once ($file);
}
function mod_autoload($class_name) {
	$file = MODCLASSBASE . 'mod'.$class_name.'.php';
	if( file_exists($file) == false ) return false;
	require_once ($file);
}

function controller_autoload($class_name) {
	$file = APP . 'controllers/'.$class_name.'.php';
	if( file_exists($file) == false ) return false;
	require_once ($file);
}
function model_autoload($class_name) {
	$file = APP . 'models/'.$class_name.'.php';
	if( file_exists($file) == false ) return false;
	require_once ($file);
}
 
spl_autoload_register('base_autoload');
spl_autoload_register('mod_autoload');
spl_autoload_register('controller_autoload');
spl_autoload_register('model_autoload');