<?php
class App extends Singleton{

	public $config = "0";
	public $data;
	private $view;
	public $modules;
	
	public function __construct() {
		$this->view = new Viewer();
		$this->modules="";
	}
	
	function start(){
		$this->config = include CONF.'config.php';
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
		$this->getPathBeforContent();
		$this->viewFinal();	
		//echo "<pre>";
		//var_dump ($this->data);
	}//END START	
	
	//устанавливаем все параметры
	private function getConf () {	
		$this->data['description'] 		=	$this->view->show(COREVIEWSHEADERS.'description','',1,1);			//описание
		$this->data['keywords']			=	$this->view->show(COREVIEWSHEADERS.'keywords','',1,1);				//ключевые слова
		$this->data['title'] 			= 	eA($this->config)->html->title;										//заголовок
		for ($i=0;$i<=count(eA($this->config)->html->css); $i++) {
			$dir_css = eA($this->config)->html->css->$i;
			$this->data['css'] = $this->data['css'].$this->view->show(COREVIEWSHEADERS.'css',$dir_css,1,1);
			}
			
		for ($i=0;$i<=count( eA($this->config)->html->js); $i++) {
			$dir_js = eA($this->config)->html->js->$i;
			$this->data['js'] = $this->data['js'].$this->view->show(COREVIEWSHEADERS.'js',$dir_js,1,1);
			}
	}

	//собираем до контента
	public function getPathBeforContent() {
		if (count(eA($this->config)->html->modules)>0) {
			foreach  ( eA($this->config)->html->modules as $k => $v ){
				//echo "K=>V: ".$k."--".$v."<br>";
				foreach ($v as $kk => $vv ) {
					if ($vv['class']=='true') {
						$kclass = ucfirst($kk); 
						$kclass::gi()->run;
						}
					if ($vv['file']=="true") $this->data['file'] = COREVIEWS.$vv['link'].'.php';
					else $this->data[$kk] = $this->view->show(COREVIEWS.$vv['link'],$this->modules,1,1);					
					}
				}
			}
		}
	
	private function viewFinal () {
		if ($this->data) if (count($this->data)>0) foreach ($this->data as $k => $v) $$k = $v;
		include $file;
		}
}