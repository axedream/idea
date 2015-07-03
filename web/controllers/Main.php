<?php
class Main extends Controller {
	
	
	public function __construct () {
			parent::__construct();
	}

	public function action_Index() {
		
		$mass = ["outPut"	=>'Коротная ссылка'	];
		$this->view->show('shortUrl',$mass);
		
		} 
	
}	