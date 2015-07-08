<?php
class Main extends Controller {

    private   $key;        //unique key for secure
    private   $pkey;       //add param form base key for secure

	public function __construct () {
		parent::__construct();
        $this->key  =   md5( MySQLDB::gi()->getDateTime() );
        $this->pkey =   md5( MySQLDB::gi()->getDateTime().mt_rand(0, 1000) );
        $_SESSION['pkey'] = $this->pkey;    //save this keys in session variable from read this key in create link
        $_SESSION['key']  = $this->key;

	}

	public function action_Index() {
        //generate value from page
		$mass = [
            "outPut"	=>  '',
            'outKey'    =>  $this->key
            ];

        //generate body bage
		$this->view->show('shortUrl',$mass);


		} 
	
}	