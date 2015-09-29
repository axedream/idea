<?php
class Main {

	public function __construct () {
		}

	public function index() {
	    //----------отображаем страницу шаблона по умолчанию
        //строим заготовку страницы
        View::gi()->setHeader();
        View::gi()->view['content']['header']               =   View::gi()->show('header','',1);            //заголовок (верхеяя полоса)
        View::gi()->view['content']['menu']['left-brends']  =   View::gi()->show('menu_left_brends','',1);  //меню брендов
        View::gi()->view['content']['body']                 =   View::gi()->show('index','',1);             //контент тела
        View::gi()->view['content']['footer']               =   View::gi()->show('footer','',1);            //подвал (нижняя полоса)
        //вывести в общем шаблоне результат
        View::gi()->uView('layout');
	    }//end Index

    //-----------------------Убрать вообще-----------------------------//
    /* пример работы с базой
    $db = new safemysql(Core::gi()->config['mysqldb']['system']);
    $sql  = "INSERT INTO test SET name=?s, value = ?s";
    $db->query($sql,"test_name","test_value");
    */
    //-----------------------Убрать вообще-----------------------------//


}