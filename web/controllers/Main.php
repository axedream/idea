<?php
class Main extends Controller {



	public function __construct () {
		parent::__construct();
		}

	public function action_Index() {
		$secure 	=	MySQLDB::gi()->getDateTime();
		//$secure = 'dsfhewuifbsmncbqweuiysaj129837';
		$_SESSION['key'] = $secure;

		$mass = [
            "outPut"	=>  '',
            'outKey'    =>  "$secure"
            ];

        //generate body bage
		$this->view->show('shortUrl',$mass);


        if ( isset ($_SESSION['shortUrl']['error']) ) {
           echo '<script>
                    $(function () {
                        setErrorMessage('.$_SESSION['shortUrl']['error'].')
                        }
                    );
                    </script>';
           }//end special input error from redirect

		}//end Index

}