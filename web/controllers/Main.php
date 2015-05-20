<?php
class Main extends Controller {
	
	
	public function __construct () {
			parent::__construct();
	}

	public function action_Index() {
		//запись в базу данных
		//echo model_Main::gi()->setDBDataUSER (['login'=>'test1','password'=>'supertest','usergroup'=>'1','name'=>'ПОЛЬЗОВАТЕЛЬ2']);	//записать в базу данных
		
		//удаление из базы данных
		//echo model_Main::gi()->delDBDataUSER (['login'=>'test'],"=");	//записать в базу данных
		
		//обновляем данные пользователя
		//echo model_Main::gi()->updateDBDataUSER (['password'=>'1'],['login'=>'test']);	//записать в базу данных
		
		//получаем все данные пользователя
		//$m=model_Main::gi()->getDBDataUSER(['login','password','name'],['login' => 'test2'],'=');
		//echo "<pre>"; var_dump ($m);
	
		//кнопка в контейнере
		//$button = $this->view->show('test/button1',['textTitle'=>'Заголовок','baseText'=>'Нажми её','textButton'=>'СуперКнопка'],1);
		//$this->view->show('test/div',['test'=>$button]);
		$this->view->show('test/main');
		
		} 
	
}	