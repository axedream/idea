<?php
namespace idea;
//--файл автозагрузки классов--//

//только дл€ базовых классов така€ автозагрузка
function baseAutoload($class) {
    $class = str_replace('idea\\','',$class);           //отсекаем namespace
    $file = mb_strtolower(BCLASS.$class.'.php');        //создаем полный путь
	if( file_exists($file) == false ) return false;     //повео€ем фай на существование, если нет не подключаем его
	require_once ($file);                               //если есть подключаем файл

}

spl_autoload_register(__NAMESPACE__.'\\baseAutoload');

