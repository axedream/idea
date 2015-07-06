<?php
class Ajax extends Controller {

    private $errors;            //variable from error in this controllers
    public  $data;              //date from this modules

	public function __construct () {
	    parent::__construct();
        App::gi()->notView=TRUE;       //disabled View standart
        }

	public function action_Index() {
		//default action
		}

	//get long url and generate short url
	public function action_Geturl() {
	    if (isset($_POST['url'])) {
            $_POST['url'];
            if (preg_math(App::gi()->regExp['full_url'],$_POST['url']) ) {
                $data = $_POST['url'];
                }//end url right
            echo 'NOT';

            }//geting url
        echo 'NOT';
		}
}	//end Ajax
