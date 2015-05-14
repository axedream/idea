<?php

define('ROOT',dirname(__FILE__).'/');				//корень
define('CORE',dirname(__FILE__).'/core/');			//ядро
define('CONF',dirname(__FILE__).'/conf/');			//конфигурация
define('APP' ,dirname(__FILE__).'/web/');			//наше приложение
define('PLUG', APP . 'plugins/');					//дополнительные компаненты (CSS,JS,...)
define('VIEW', APP . 'views/');						//отображение

require_once CONF.'autoload.php';					//базовые классы

App::gi()->start();									//goooo!	