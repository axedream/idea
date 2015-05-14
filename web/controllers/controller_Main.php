<?php
class Main extends Controller {
	
	
	public function __construct () {
			parent::__construct();
	}

	public function action_index() {
		$data['test'] = "URL";
		
		$this->view("test2",$data);
		$this->view("test",$data);
		
		} 
}