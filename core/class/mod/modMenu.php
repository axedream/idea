<?php
class Menu extends Singleton{

	public $config;
	public $controller;
	public $action;
	public $button;

	function __construct() {
		$this->controller	=	App::gi()->controller;
		$this->action		=	App::gi()->action;	
		$this->config		=	App::gi()->config['html']['menu'];
		//echo "<pre>";
		//var_dump($this->config);
		}

	//метод построения кнопок
	public function getAction (){
		foreach ($this->config as $k => $v) {
		$id = $v['id']? $id = $v['id'] : ''; 
		$glyphicon = $v['glyphicon'] ? "<span class=\"glyphicon ".$v['glyphicon']."\"></span>" : '';
		$active = $this->controller==ucfirst($k)? "<li class=\"active\"> " : "<li>";
		$this->button[$v['group']] = $this->button[$v['group']]."\n\r".$active."<a href=\"".URL.$k.'/'.$v['action'].'/'.$id."\">".$glyphicon."&nbsp;&nbsp;".$v['name']."</a></li>";			
		}
	}
	
	//устанавливает меняет свойства меню
	public function run() {
		//получаем посмтроенные кнопки
		$this->getAction();
		//авторизация
		$this->button['log'] = $this->button['login'];
		App::gi()->modules['button'] = $this->button;
		}
}