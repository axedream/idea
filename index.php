<?php
require_once 'directory.php';               //константы переменных
require_once BASE.'autoload.php';           //автозагрузка классов

Core::gi()->run();

//-----------------------”брать вообще-----------------------------//
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
//-----------------------”брать вообще-----------------------------//


?>