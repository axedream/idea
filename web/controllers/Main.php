<?php
class Main extends Controller {



	public function __construct () {
		parent::__construct();
		}

	public function action_Index() {
        //generate body bage
		$this->view->show('shortUrl');

		}//end Index

}