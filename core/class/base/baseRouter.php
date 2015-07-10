<?php
class Router extends Singleton {
	public $controller;			//контроллер
	public $action;				//действие 
	public $id;					//текущее ИД
	public $def_controller;		//контроллер загружаемый по дефолту
	public $def_action;			//действие загружаемое по дефолту
	public $def_id;				//ID загружаемые по дефолту
	public $config;				//весь конфиг
	private $regExp;			//регулярные выражения для проверки


	function __construct () {
		$this->regExp['controller']	= App::gi()->config['regexp']['uri']['controller'];
		$this->regExp['action']		= App::gi()->config['regexp']['uri']['action'];
		$this->regExp['id']			= App::gi()->config['regexp']['uri']['id'];
        $this->regExp['short_ulr']  = App::gi()->config['regexp']['uri']['short_ulr'];
        $this->regExp['full_url']   = App::gi()->config['regexp']['uri']['full_url'];
		$this->def_controller		= App::gi()->config['appconfig']['default_controller'];
		$this->def_action			= App::gi()->config['appconfig']['default_action'];
		$this->def_id				= App::gi()->config['appconfig']['default_id'];
		}

	//функция парсинга ЧПУ (человекопонятный урл)
	function parse(){
		$routes = explode('/', $_SERVER['REQUEST_URI']);
        if ( preg_match ($this->regExp['short_ulr'], trim($routes[1] )))	{
            //if short url input -> this function todo
            App::gi()->notView = TRUE;
            //run special procedure from worke short link
            
            } //end short url
        else {
            //if not short url then action this function
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



    		for ($i=3;$i<=10;$i++){
    			if (!empty($routes[$i])){
    				if (preg_match($this->regExp['id'], trim($routes[$i])))	{
    					$this->id[$i-3]	= $routes[$i];
    					}
    			    }
    		    }//end for

    		if (!isset($this->id['0'])) $this->id['0'] = $this->def_id;
        }// end else shrot url
	}
}