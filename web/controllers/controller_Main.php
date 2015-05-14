<?php
class Main extends Controller {
	
	function __construct () {
			parent::__construct();
	}

	public function action_index() {
		echo __CLASS__;
	} 
}