<?php
require_once 'directory.php';               //константы переменных
require_once BASE.'autoload.php';           //автозагрузка классов

Core::gi()->run();

View::gi()->pageDefault();

//------------вынести в отдельное дефолтное отображение-------------//
//Готовое отображение макетной страницы
echo View::gi()->view['html']['head'];
echo View::gi()->view['headerBuild'];
echo View::gi()->view['body']['up'];
echo View::gi()->view['body']['down'];
//------------вынести в отдельное дефолтное отображение-------------//

//-----------------------Убрать вообще-----------------------------//
/*
echo "<pre>";
var_dump(Core::gi()->config);
echo "<br>";
*/
/* пример работы с базой
$db = new safemysql(Core::gi()->config['mysqldb']['system']);
$sql  = "INSERT INTO test SET name=?s, value = ?s";
$db->query($sql,"test_name","test_value");
*/
//-----------------------Убрать вообще-----------------------------//


?>