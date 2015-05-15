<?php
class Main extends Controller {
	
	
	public function __construct () {
			parent::__construct();
	}

	public function action_index() {
		$this->view("test/test1",model_Main::gi()->getTestData(__CLASS__));
		$this->view("test/test2",model_Main::gi()->getTestData());
		} 
}	