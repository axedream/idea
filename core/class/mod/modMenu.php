<?php
class Menu extends Singleton{

	public $config;
	public $controller;
	public $action;
	public $button;
	public $view;
	
	function __construct() {
		$this->controller	=	App::gi()->controller;
		$this->action		=	App::gi()->action;
		$this->config		=	App::gi()->config['html']['menu'];
		$this->view = new Viewer;
		}

	//метод построения кнопок
	public function getAction (){
		foreach ($this->config as $k => $v) {
			if (isset($v['id'])) $id = $v['id'] ? $id = $v['id'] : '';
			$glyphicon = $v['glyphicon'] ? "<span class=\"glyphicon ".$v['glyphicon']."\"></span>" : '';
			$url = (isset($k['controller'])) ? URL.$v['controller'].'/'.$v['action'].'/'.$id : URL.$k.'/'.$v['action'].'/'.$id;
			$href	=	"href=\"".$url."\"";
			(isset($v['modal'])) ? $href =' href="" ' : $v['modal'] = '';
			@App::gi()->data['modal'] = App::gi()->data['modal'].$this->view->show($v['modal_box'],['url' => $url ],1);

            //если контроллер и действие то рисуем активную кнопку
			//$active = ($this->controller==ucfirst($k) && $this->action == "action_".$v['action'])? "<li class=\"active\"> " : "<li>";

            //если только контроллер рисуем активную кнопку
            $active = ($this->controller==ucfirst($k))? "<li class=\"active\"> " : "<li>";

			@$this->button[$v['group']] = $this->button[$v['group']]."\n\r".$active."<a ".$href.$v['modal'].">".$glyphicon."&nbsp;&nbsp;".$v['name']."</a></li>";

            //подменю
			if (isset($v['submenu'])) {
				
				}//submenu
			}
	}
	
	//устанавливает меняет свойства меню
	public function run() {
		//получаем посмтроенные кнопки
		$this->getAction();
		//кнопка авторизации (!!!!!!!!!!!!!!!продумать когда её ставить когда нет) - связать с сессией (продумать модуль авторизаци)
		@$this->button['log'] = $this->button['log'].$this->button['register'].$this->button['login'];			//кнопка авторизации

		App::gi()->modules['menu'] = $this->button;
		}
}