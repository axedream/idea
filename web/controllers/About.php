<?php
class About extends Controller {
	
	
	public function __construct () {
			parent::__construct();
	}

	public function action_index() {
		$this->view->show('about/text');
		} 
	
}	