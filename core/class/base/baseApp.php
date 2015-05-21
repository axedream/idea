<?php
class App extends Singleton{

	public $config = "0";
	public $data;
	private $view;
	public $modules;
	public $controller;					//вызванный пользовательский контроллер
	public $action;						//вызванный пользовательское действие
	public $rip;
	
	public function __construct() {
		if (!session_start()) exit;		//проработать вывод сообщений, что данный сайт не поддерживает работы без сессий
		if (!isset($_SESSION['group'])) $_SESSION['group']	= 'guest';	//устанавливает по умолчанию группу guest
		if (!isset($_SESSION['user'])) 	$_SESSION['user'] 	= 'guest';	//устанавливает по умолчанию пользователя guest		
		$this->view = new Viewer();
		$this->config = include CONF.'config.php';
		$this->rip = $_SERVER['REMOTE_ADDR'];
		if (!isset($this->data['content'])) $this->data['content'] = ''; 
	}
	
	//ключевой метод запуска движка
	function start(){
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
			$controller = new $controller; 
			$controller->$action();
			}	
		else{
			$cn = Router::gi()->def_controller; 
			$controller	= ucfirst($cn);
			$ac = Router::gi()->def_action;		
			$action		= "action_".$ac;
			if(method_exists($controller, $action)) {
				$this->controller = $controller;
				$this->action = $action;
				$controller = new $controller;
				$controller->$action();
				}
			else {
				//echo "Полная жопа!!!"."<br>";
				}
			}// END ELSE СТРАНИЦЫ ПО ДЕФОЛТУ	
		}
	
	//устанавливаем все параметры (header)
	private function getConf () {	
		$this->data['description'] 		=	$this->view->show(COREVIEWSHEADERS.'description','',1,1);			//описание
		$this->data['keywords']			=	$this->view->show(COREVIEWSHEADERS.'keywords','',1,1);				//ключевые слова
		$this->data['title'] 			= 	eA($this->config)->html->title;										//заголовок
		
		if (count ($this->config['html']['css'])>0) foreach ($this->config['html']['css'] as $k => $v)
			@$this->data['css'] = $this->data['css']."\r\n".$this->view->show(COREVIEWSHEADERS.'css',$v,1,1);	

		if (count($this->config['html']['js'])>0) foreach ($this->config['html']['js'] as $k => $v)
			@$this->data['js'] = $this->data['js']."\r\n".$this->view->show(COREVIEWSHEADERS.'js',$v,1,1);
		}

	//собираем модули
	public function getPathBeforContent() {
		//echo "<pre>"; var_dump($this->config['html']['modules']);
		if (count( $this->config['html']['modules'])>0) {
			foreach  ( $this->config['html']['modules'] as $k => $v ){
				if ($v['class']) {
					$kclass = ucfirst($k); 
					$kclass::gi()->run();
					}
				if ($v['file']) $this->data['file'] = COREVIEWS.$v['link'].'.php';
				else $this->data[$k] = $this->view->show(COREVIEWS.$v['link'],$this->modules,1,1);				
				}
			}
		}
		
	//отображаем ключевую страницу
	private function viewFinal () {
		foreach ($this->data as $k => $v) $$k = $v;
		include $file;
		}
}