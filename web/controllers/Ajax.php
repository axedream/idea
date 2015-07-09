<?php
class Ajax extends Controller {

    private $errors;            //variable from error in this controllers
    public  $data;              //date from this modules
    public  $post=FALSE;              //data post

	public function __construct () {
	    parent::__construct();
        App::gi()->notView=TRUE;                    //disabled View standart
        if (isset($_POST['output'])) $this->post = json_decode ($_POST['output'], TRUE);   //set massive post from $THIS->POST
        }

	public function action_Index() {
		//default action
        if ($this->post['controller']) {
            switch ($this->post['controller']) {
                case 'shorturl' : $this->_shorturl(); break;
                }//end switch
            }
        else echo 'NOT';
		}

	//get long url and generate short url
	public function _shorturl() {
        if (preg_match(App::gi()->config['regexp']['uri']['full_url'],$this->post['url']) ) {
            //get request in module shortulr
            Shorturl::gi()->key = $this->post['key'];
            Shorturl::gi()->url = $this->post['url'];
			//success
			if ( !(Shorturl::gi()->setUrl ()) ) {
				
				}
			//error
			else {
				
				}
            }//end url right
        else echo 'NOT';
        
        }//geting url
}//end Ajax
