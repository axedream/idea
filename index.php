<?php

define('ROOT',dirname(__FILE__).'/');				//корень
define('CORE',dirname(__FILE__).'/core/');			//ядро
define('APP' ,dirname(__FILE__).'/web/');			//наше приложение
define('CONF',dirname(__FILE__).'/conf/');			//конфигурация
define('PLUG',dirname(__FILE__).APP.'plugins/');	//дополнительные компаненты (CSS,JS,...)


require_once CONF.'autoload.php';					//базовые классы

App::gi()->start();									//goooo!	