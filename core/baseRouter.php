<?php
class Router extends Singleton {
	public $controller;
	public $action;
	public $id;
	public $def_controller;
	public $def_action;
	public $def_id;
	public $config;
	private $regExp;
	
	function __construct () {
		$this->regExp['controller']	= eArray::gi()->eA(App::gi()->config)->regexp->uri->controller;
		$this->regExp['action']		= eArray::gi()->eA(App::gi()->config)->regexp->uri->action;
		$this->regExp['id']			= eArray::gi()->eA(App::gi()->config)->regexp->uri->id;
		$this->def_controller		= App::gi()->config['default_controller'];
		$this->def_action			= App::gi()->config['default_action'];
		$this->def_id				= App::gi()->config['default_id'];
	}
	
	//функция парсинга ЧПУ (человекопонятный урл)
	function parse(){
		$routes = explode('/', $_SERVER['REQUEST_URI']);

		if (!empty($routes[1])){
			if (preg_match($this->regExp['controller'], trim($routes[1]))) $this->controller = $routes[1];
			else $this->controller = $this->def_controller;
		}
		else $this->controller = $this->def_controller;
		
		
		if (!empty($routes[2])){
			if (preg_match($this->regExp['action'], trim($routes[2]))) $this->action = $routes[2];
			else $this->action = $this->def_action;
		}
		else $this->action = $this->def_action;
		
		if (!empty($routes[3])){
			if (preg_match($this->regExp['id'], trim($routes[3]))) $this->id = $routes[3];
			else $this->id = $this->def_id;
		}
		else $this->id = $this->def_id;
		
	}
}