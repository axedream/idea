<?php
class Main extends Controller {
	
	
	public function __construct () {
			parent::__construct();
	}

	public function action_index() {
		//простое отображение
		$this->view("test/test1",model_Main::gi()->getTestTexData());

		//запись в базу данных
		//echo model_Main::gi()->setDBDataUSER (['login'=>'test1','password'=>'supertest','usergroup'=>'1','name'=>'ПОЛЬЗОВАТЕЛЬ2']);	//записать в базу данных
		
		//удаление из базы данных
		//echo model_Main::gi()->delDBDataUSER (['login'=>'test'],"=");	//записать в базу данных
		
		//обновляем данные пользователя
		//echo model_Main::gi()->updateDBDataUSER (['password'=>'1'],['login'=>'test']);	//записать в базу данных
		
		//получаем все данные пользователя
		//$m=model_Main::gi()->getDBDataUSER(['login','password','name'],['login' => 'test2'],'=');
		//echo "<pre>"; var_dump ($m);

		} 
		
}	