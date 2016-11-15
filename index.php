<?php
require_once 'directory.php';               //константы переменных
require_once BASE.'autoload.php';           //автозагрузка классов

//инициализируем загрузку
Core::gi()->run();

//отрисовываем контент
View::gi()->getPage();
?>