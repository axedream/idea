<?php
class Main extends Controller {

    
	public function __construct () {
		parent::__construct();
		}

	public function action_Index() {
		$secure 	=	MySQLDB::gi()->getDateTime();
		//$secure = 'dsfhewuifbsmncbqweuiysaj129837';
		$_SESSION['key'] = $secure;
        //generate value from page
		$mass = [
            "outPut"	=>  '',
            'outKey'    =>  "$secure"
            ];

        //generate body bage
		$this->view->show('shortUrl',$mass);
		} 
	
}	