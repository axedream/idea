<?php
class Main extends Controller {
	
	
	public function __construct () {
			parent::__construct();
	}

	public function action_Index() {
	
		DLL_DB::gi()->getHelpData ('header_dynamictext');
		$mass = DLL_DB::gi()->dataDB;
		
		$this->view->show('test/mainTest',$mass);
		
		} 
	
}	