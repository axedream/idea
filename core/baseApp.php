<?php
class App extends Singleton{

	public $config = "0";
	public $data;
	
	public function __construct() {}
	
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
		
		//сборка и загрузка страницы
		$this->getConf();
		$this->view_final();	
	}//END START	
	
	//устанавливаем все параметры
	private function getConf () {
		$this->data['description'] 		=	"<meta name=\"description\" content=\"".eArray::gi()->eA($this->config)->html->description."\" />";
		$this->data['keywords']			=	"<meta name=\"keywords\" content=\"".eArray::gi()->eA($this->config)->html->keywords."\"/>";
		$this->data['title'] 			= 	eArray::gi()->eA($this->config)->html->title;
		$this->data['file']				=	VIEW.eArray::gi()->eA($this->config)->layouts.'.php';
		for ($i=0;$i<=count(eArray::gi()->eA(App::gi()->config)->html->css); $i++) {
			$dir_css = eArray::gi()->eA($this->config)->html->css->$i;
			$this->data['css'] = $this->data['css']."<link rel=\"stylesheet\" type=\"text/css\" href=\"".$dir_css."\"/>";
			}
		for ($i=0;$i<=count(eArray::gi()->eA(App::gi()->config)->html->js); $i++) {
			$dir_js = eArray::gi()->eA($this->config)->html->js->$i;
			$this->data['js'] = $this->data['js']."<script type=\"text/javascript\" src=\"".$dir_js."\"></script>";
			}

	}
	
	//конечное отображение шаблона
	private function view_final () {
		$data = $this->data;
		include $data['file'];
		}
}