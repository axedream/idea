<?php
class Controller extends Singleton {
	public $view;

	public function __construct () {
		$this->view = new Viewer();		
	}
	
}