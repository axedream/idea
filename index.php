<?php

define('ROOT',dirname(__FILE__).'/');					//корень
define('CORE',dirname(__FILE__).'/core/');				//ядро
define('CORECLASS',CORE.'class/');						//ядро классов
define('CORECLASSBASE',CORECLASS.'base/');				//ядро классов базовое
define('CORECLASSAUTOLOAD',CORECLASS.'autoload/');		//ядро классов автозагрузочное
define('COREVIEWS',CORE.'views/');						//ядро отображений
define('COREVIEWSFORM',COREVIEWS.'forms/');				//ядро отображений форм
define('COREVIEWSHEADERS',COREVIEWS.'headers/');		//ядро отображений заголовков
define('COREVIEWSBUTTONS',COREVIEWS.'buttons/');		//ядро отображений кнопок
define('CONF',dirname(__FILE__).'/conf/');				//конфигурация
define('APP' ,dirname(__FILE__).'/web/');				//наше приложение
define('PLUG', APP . 'plugins/');						//дополнительные компаненты (CSS,JS,...)
define('VIEW', APP . 'views/');							//отображение

/*
echo "<table>";
echo "<tr><td>КОРЕНЬ 							</td><td>".ROOT."				</td></tr>";
echo "<tr><td>ЯДРО 								</td><td>".CORE."				</td></tr>";
echo "<tr><td>ЯДРО КЛАССОВ 						</td><td>".CORECLASS."			</td></tr>";
echo "<tr><td>ЯДРО КЛАССОВ БАЗОВОЕ				</td><td>".CORECLASSBASE."		</td></tr>";
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