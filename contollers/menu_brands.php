<?php

//создание меню брендов
class Menu_brands{

    public $table;

    function __construct() {
        $this->table['list'] = 'charlie_brands';
        }

    //получение данных меню
    public function getData() {
        $db = new safemysql(Core::gi()->config['mysqldb']['system']);
        $data = $db->getAll("SELECT * FROM ".$this->table['list']);
        return $data;
        }//end function getData

    //отрисовка меню
    public function showMenu() {
        $data = $this->getData();
        //пересылаем данные в форму отображения
        View::gi()->view['content']['menu']['left-brends']  =   View::gi()->show('menu_left_brends','',1);  //меню брендов
        }

}