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
		$this->viewFinal();	
	}//END START	
	
	//устанавливаем все параметры
	private function getConf () {
		$this->data['description'] 		=	$this->viewCore(COREVIEWSHEADERS.'description');	//описание
		$this->data['keywords']			=	$this->viewCore(COREVIEWSHEADERS.'keywords');		//ключевые слова
		$this->data['title'] 			= 	eA($this->config)->html->title;						//заголовок
		$this->data['file']				=	VIEW.eA($this->config)->layouts.'.php';				//файл макета

		for ($i=0;$i<=count(eA(App::gi()->config)->html->css); $i++) {
			$dir_css = eA($this->config)->html->css->$i;
			$this->data['css'] = $this->data['css'].$this->viewCore(COREVIEWSHEADERS.'css');
			}
			
		for ($i=0;$i<=count(eA(App::gi()->config)->html->js); $i++) {
			$dir_js = eA($this->config)->html->js->$i;
			$this->data['js'] = $this->data['js'].$this->viewCore(COREVIEWSHEADERS.'js');
			}

	}
	

	private function viewCore ($file,$data="null") {
		$file = $file.'.php';
		ob_start();
		if( file_exists($file) == false ) return false;
		else{
			include $file;
			$m = ob_get_contents();
			ob_clean(); ob_end_flush();
			return $m;
			}
		}
	
	private function viewFinal () {
		$data = $this->data;
		include $data['file'];
		}
}