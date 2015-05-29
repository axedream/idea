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
        $name   = $array['name'];
        $glyphicon = $array['glyphicon'];
        //echo $button."<br>";
        //левый ряд кнопок
        if ( $array['group'] == 'left' ) {
          $this->button['left'] = @$this->button['left'].$this->view->show($button,['active'=>$active,'name'=>$name,'url'=>$url,'glyphicon'=>$glyphicon],1,1);
          }//end left

        //правый ряд кнопок (тут аторизации поэтому идет предварительный разбор)
        if ( $array['group'] == 'right' ) {
          if (User::gi()->flagAut && $m=='logout') $this->button['right'] = $this->view->show($button,['active'=>$active,'name'=>$name,'url'=>$url,'glyphicon'=>$glyphicon],1,1);
          if (!User::gi()->flagAut && $m=='login') $this->button['right'] = $this->view->show($button,['active'=>$active,'name'=>$name,'url'=>$url,'glyphicon'=>$glyphicon],1,1);
          }//end right
        }//end foreach


      //$this-$this->view->show(COREVIEWS.'layouts/button',[],1);
      /*
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

      */


	}

	public function run() {

		$this->getAction();
		//if (User::gi()->flagAut) @$this->button['log'] = $this->button['log'].$this->button['logout'];
    //else @$this->button['log'] = $this->button['log'].$this->button['register'].$this->button['login'];			//кнопка авторизации
		App::gi()->modules['menu'] = $this->button;
		}
}