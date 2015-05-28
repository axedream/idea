<?php

ini_set("display_errors",1);
error_reporting(E_ALL); 

$server = $_SERVER['SERVER_ADDR'];
date_default_timezone_set('Asia/Novosibirsk');

if ($server=="192.168.54.110")	define('URL', 'http://host-1.ru/');	//реальный хост	
if ($server=="127.0.0.1")		define('URL', 'http://localhost/');	//URL

$input = str_replace('\\','/',__DIR__);

define('ROOT',$input.'');								//корень
define('CORE',$input.'/core/');							//ядро
define('CORECLASS',CORE.'class/');						//ядро классов
define('CORECLASSBASE',CORECLASS.'base/');				//ядро классов базовое
define('MODCLASSBASE',CORECLASS.'mod/');				//ядро классов модульное
define('COREIMG',URL.'core/views/');					//картинки ядра
define('CORECLASSAUTOLOAD',CORECLASS.'autoload/');		//ядро классов автозагрузочное
define('COREVIEWS',CORE.'views/');						//ядро отображений
define('COREVIEWSFORM',COREVIEWS.'forms/');				//ядро отображений форм
define('COREVIEWSHEADERS',COREVIEWS.'headers/');		//ядро отображений заголовков
define('COREVIEWSBUTTONS',COREVIEWS.'buttons/');		//ядро отображений кнопок
define('CONF',$input.'/conf/');							//конфигурация
define('APP' ,$input.'/web/');							//наше приложение
define('PLUG', URL . 'web/plugins/');					//дополнительные компаненты (CSS,JS,...)
define('VIEW', APP . 'views/');							//отображение



/*
echo "<table>";
echo "<tr><td>КОРЕНЬ 							</td><td>".ROOT."				</td></tr>";
echo "<tr><td>ЯДРО 								</td><td>".CORE."				</td></tr>";
echo "<tr><td>ЯДРО КЛАССОВ 						</td><td>".CORECLASS."			</td></tr>";
echo "<tr><td>ЯДРО КЛАССОВ БАЗОВОЕ				</td><td>".CORECLASSBASE."		</td></tr>";
echo "<tr><td>ЯДРО КЛАССОВ МОДУЛЬНОЕ			</td><td>".MODCLASSBASE."		</td></tr>";
echo "<tr><td>ЯДРО КЛАССОВ АВТОЗАГРУЗОЧНОЕ		</td><td>".CORECLASSAUTOLOAD."	</td></tr>";
echo "<tr><td>ЯДРО ОТОБРАЖЕНИЙ					</td><td>".COREVIEWS."			</td></tr>";
echo "<tr><td>ЯДРО ОТОБРАЖЕНИЙ ФОРМ				</td><td>".COREVIEWSFORM."		</td></tr>";
echo "<tr><td>ЯДРО ОТОБРАЖЕНИЙ ЗАГОЛОВКОВ		</td><td>".COREVIEWSHEADERS."	</td></tr>";
echo "<tr><td>ЯДРО ОТОБРАЖЕНИЙ КНОПОК			</td><td>".COREVIEWSBUTTONS."	</td></tr>";
echo "<tr><td>КОНФИГУРАЦИЯ						</td><td>".CONF."				</td></tr>";
echo "<tr><td>ПРИЛОЖЕНИЕ						</td><td>".APP."				</td></tr>";
echo "<tr><td>ДОП КОМПАНЕНТЫ CSS JS				</td><td>".PLUG."				</td></tr>";
echo "<tr><td>ОТОБРАЖЕНИЯ						</td><td>".VIEW."				</td></tr>";
echo "</table>";
*/

require_once CORECLASSAUTOLOAD.'autoloadLoader.php';	//класс автозагрузки
require_once CORECLASSAUTOLOAD.'autoloadArray.php';		//класс обработки массивов

App::gi()->start();										//goooo!