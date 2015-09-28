<?php
class Main {

	public function __construct () {
		}

	public function index() {
	    //отображаем страницу шаблона по умолчанию
        View::gi()->pageDefault();
        View::gi()->uView('layout');
		}//end Index


}