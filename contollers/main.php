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

    //public function

}