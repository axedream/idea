<?php
class Menu extends Singleton{

	public $config;
	public $controller;
	public $action;
	public $button;
	public $view;
	
	function __construct() {
		$this->controller	  =	App::gi()->controller;
		$this->action		    =	App::gi()->action;
		$this->config		    =	App::gi()->config['html']['menu'];
		$this->view = new Viewer;
		}

	//метод построения кнопок
	public function getAction (){
      $button = COREVIEWS.'layouts/button';

      foreach ($this->config as $m =>$array) {
        $array['controller'] = ucfirst($array['controller']);
        $active = ($this->controller == $array['controller']) ? 'active' : '';
        $url    = URL.$array['controller'].'/'.$array['action'].'/'.$array['id'];

        if ($array['modal']) {
          $modal = $array['modal'];
          $url='';
          App::gi()->data['modal'] = $this->view->show($array['modal_box'],['url'=>URL.$array['modal_url']],1);
          }
        else $modal = '';

        $name   = $array['name'];
        $glyphicon = $array['glyphicon'];

        //echo $button."<br>";
        //левый ряд кнопок
        if ( $array['group'] == 'left' ) {
          $this->button['left'] = @$this->button['left'].$this->view->show($button,['active'=>$active,'name'=>$name,'url'=>$url,'glyphicon'=>$glyphicon,'modal'=>$modal],1,1);
          }//end left

        //правый ряд кнопок (тут аторизации поэтому идет предварительный разбор)
        if ( $array['group'] == 'right' ) {
          if (User::gi()->flagAut && $m=='logout') $this->button['right'] = $this->view->show($button,['active'=>$active,'name'=>$name,'url'=>$url,'glyphicon'=>$glyphicon,'modal'=>$modal],1,1);
          if (!User::gi()->flagAut && $m=='login') $this->button['right'] = $this->view->show($button,['active'=>$active,'name'=>$name,'url'=>$url,'glyphicon'=>$glyphicon,'modal'=>$modal],1,1);
          }//end right
        }//end foreach
	}

	public function run() {

		$this->getAction();
   	App::gi()->modules['user'] = $user   = "Пользователь:&nbsp;". User::gi()->user.'&nbsp';
		App::gi()->modules['menu'] = $this->button;
		}
}