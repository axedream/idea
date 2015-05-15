<?php
class Main extends Controller {
	
	
	public function __construct () {
			parent::__construct();
	}

	public function action_index() {
		//простое отображение
		$this->view("test/test1",model_Main::gi()->getTestTexData());

		//запись в базу данных
		//model_Main::gi()->setDBDataUSER (['login'=>'test','password'=>'supertest','usergroup'=>'3','name'=>'ПОЛЬЗОВАТЕЛЬ']);	//записать в базу данных
		
		//удаление из базы данных
		//model_Main::gi()->delDBDataUSER (['login'=>'test'],"=");	//записать в базу данных
		
		//обновляем данные пользователя
		//model_Main::gi()->updateDBDataUSER (['password'=>'super'],['login'=>'test']);	//записать в базу данных
		
		} 
		
}	