<?php
require_once 'directory.php';               //константы переменных
require_once BASE.'autoload.php';           //автозагрузка классов

Core::gi()->run();

View::gi()->setHeader();
View::gi()->setUpBody();
View::gi()->setDownBody();
View::gi()->setHtmlHead();

echo View::gi()->view['html']['head'];
echo View::gi()->view['headerBuild'];
echo View::gi()->view['body']['up'];

/*
echo "<pre>";
var_dump(Core::gi()->config);
echo "<br>";
*/

echo View::gi()->view['body']['down'];
?>