<?php
//--���� ������������ �������--//


//������� ������ ����
function base_autoload($class_name) {
	$file = BCLASS .$class_name.'.php';
	if( file_exists($file) == false ) return false;
	require_once ($file);
}


spl_autoload_register('base_autoload');

