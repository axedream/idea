<?php
class Main extends Controller {



	public function __construct () {
		parent::__construct();
		}

	public function action_Index() {
	    $mass['message'] = '<div>Enter long URL</div><div>press Do</div><div>copy the get received URL<div>';

        if (Router::gi()->hidden['shorturl'] == "yes") $mass['message'] = Shorturl::gi()->output['message'];

        $this->view->show('shortUrl',$mass);
		}//end Index

}