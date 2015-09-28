<?php
//--файл автозагрузки классов--//


//базовые классы ядра
function base_autoload($class_name) {
    $class_name = mb_strtolower($class_name);
	$file = BCLASS .$class_name.'.php';
	if( file_exists($file) == false ) return false;
	require_once ($file);
}

//пользовательские контроллеры
function user_autoload($class_name) {
    $class_name = mb_strtolower($class_name);
	$file = UCLASS .$class_name.'.php';
	if( file_exists($file) == false ) return false;
	require_once ($file);
}


//базовые класс
spl_autoload_register('base_autoload');

//пользовательские классы
spl_autoload_register('user_autoload');

