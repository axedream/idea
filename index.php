<?php
require_once 'directory.php';               //��������� ����������
require_once BASE.'autoload.php';           //������������ �������

Core::gi()->run();

//-----------------------������ ������-----------------------------//
/*
echo "<pre>";
var_dump(Core::gi()->config);
echo "<br>";
*/
/* ������ ������ � �����
$db = new safemysql(Core::gi()->config['mysqldb']['system']);
$sql  = "INSERT INTO test SET name=?s, value = ?s";
$db->query($sql,"test_name","test_value");
*/
//-----------------------������ ������-----------------------------//


?>