<?php
class Main {

	public function __construct () {
		}

	public function index() {

	    //----------отображаем страницу шаблона по умолчанию
        //пресеты
        View::gi()->pageDefault();
        //устанавливаем переменную content равную файлу конента
        View::gi()->show('index');
        //вывести в общем шаблоне результат
        View::gi()->uView('layout');
	    }//end Index

    public function test() {

        //-----------------------Убрать вообще-----------------------------//

        echo "<pre>";
        var_dump(Core::gi()->router);
        echo "<br>";

        /* пример работы с базой
        $db = new safemysql(Core::gi()->config['mysqldb']['system']);
        $sql  = "INSERT INTO test SET name=?s, value = ?s";
        $db->query($sql,"test_name","test_value");
        */
        //-----------------------Убрать вообще-----------------------------//

        }//end test
    //public function

}