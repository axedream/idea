<?php
class App extends Singleton{

	public $config = "0";
	public $data;
	private $view;
	public $modules;
	public $controller;					//вызванный пользовательский контроллер
	public $action;						//вызванный пользовательское действие
	
	public function __construct() {
		$this->view = new Viewer();
	}
	
	//ключевой метод запуска движка
	function start(){
		$this->config = include CONF.'config.php';
		Router::gi()->parse();			//парсим URL
		$this->runUserController();		//загружаем пользовательский контроллер		
		$this->getConf();				//получаем HEADER
		$this->getPathBeforContent();	//загружаем модули
		$this->viewFinal();				//отрисовываем финальную страницу	
		}//END START	

	//сборка и загрузка страницы
	private function runUserController () {

		$cn = Router::gi()->controller;	
		$controller	= ucfirst($cn);
		$ac = Router::gi()->action;		
		$action		= "action_".$ac;

		if(method_exists($controller, $action)) {
			$this->controller = $controller;
			$this->action = $action;
			//echo "Контроллер прошел удачно, создаем: ".$controller."<br>";
			//echo "Действие прошло удачно создаем: ".$action."<br>";

			$controller = new $controller; 
			$controller->$action();
			}	
		else{

			//вывести страницу по дефолту
			$cn = Router::gi()->def_controller; 
			$controller	= ucfirst($cn);
			$ac = Router::gi()->def_action;		
			$action		= "action_".$ac;

			//echo "пробуем дефолтный: ".$controller."<br>";
			//echo "пробуем дефолтный: ".$action."<br>";

			if(method_exists($controller, $action)) {
				$this->controller = $controller;
				$this->action = $action;
				$controller = new $controller;
				$controller->$action();
				}
			//исключение нужно как то отработать
			else {
				//echo "Полная жопа!!!"."<br>";
				}
			}// END ELSE СТРАНИЦЫ ПО ДЕФОЛТУ	
			
		//echo "Контроллер на выходе ".__CLASS__.": ".$this->controller."<br>";
		//echo "Действие на выходе".__CLASS__.": ".$this->action."<br>";
		}
	
	//устанавливаем все параметры (header)
	private function getConf () {	
		$this->data['description'] 		=	$this->view->show(COREVIEWSHEADERS.'description','',1,1);			//описание
		$this->data['keywords']			=	$this->view->show(COREVIEWSHEADERS.'keywords','',1,1);				//ключевые слова
		$this->data['title'] 			= 	eA($this->config)->html->title;										//заголовок
		
		if (count ($this->config['html']['css'])>0) foreach ($this->config['html']['css'] as $k => $v)
			$this->data['css'] = $this->data['css']."\r\n".$this->view->show(COREVIEWSHEADERS.'css',$v,1,1);	

		if (count($this->config['html']['js'])>0) foreach ($this->config['html']['js'] as $k => $v)
			$this->data['js'] = $this->data['js']."\r\n".$this->view->show(COREVIEWSHEADERS.'js',$v,1,1);
		}

	//собираем модули до контента
	public function getPathBeforContent() {
		if (count(eA($this->config)->html->modules)>0) {
			foreach  ( eA($this->config)->html->modules as $k => $v ){
				//echo "K=>V: ".$k."--".$v."<br>";
				foreach ($v as $kk => $vv ) {
					if ($vv['class']=='true') {
						$kclass = ucfirst($kk); 
						$kclass::gi()->run();
						//echo "Модуль: ".$kclass."<br>";
						}
					if ($vv['file']=="true") $this->data['file'] = COREVIEWS.$vv['link'].'.php';
					else $this->data[$kk] = $this->view->show(COREVIEWS.$vv['link'],$this->modules,1,1);					
					}
				}
			}
		}
	//отображаем ключевую страницу
	private function viewFinal () {
		if ($this->data) if (count($this->data)>0) foreach ($this->data as $k => $v) $$k = $v;
		include $file;
		}
}