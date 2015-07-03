<?php
class Main extends Controller {
	
	
	public function __construct () {
			parent::__construct();
	}

	public function action_Index() {
		
		$mass = ["test"	=>'ttt'	];
		$this->view->show('shortUrl',$mass);
		
		} 
	
}	