<?php
class App extends Singleton{

	public $config = "0";
	
	
	function start(){
		$this->config = include CONF.'config.php';						//полключаем конфиг
		Router::gi()->parse();
		$cn = Router::gi()->controller;	$controller	= ucfirst($cn);
		$ac = Router::gi()->action;		$action		= "action_".$ac;
		if(method_exists($controller, $action)) {
			$controller = new $controller;
			$controller->$action();
			}	
		else{
			//вывести страницу по дефолту
			$cn = Router::gi()->def_controller; $controller	= ucfirst($cn);
			$ac = Router::gi()->def_action;		$action		= "action_".$ac;
		if(method_exists($controller, $action)) {
			$controller = new $controller;
			$controller->$action();
			}
		}// END ELSE СТРАНИЦЫ ПО ДЕФОЛТУ
	}//END START
}