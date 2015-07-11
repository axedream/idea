<?php
class Ajax extends Controller {

    public  $post=FALSE;        //data post
    public  $output;            //return data

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
        //encode data
        $this->output = json_encode($this->output);
        echo $this->output;
		}

	//get long url and generate short url
	public function _shorturl() {
	    if ($this->post['action'] == 'set') {
			$this->output = Shorturl::gi()->setUrl ($this->post['url']);
            }//end ACTION SET
        }//end function _shorturl
}//end Ajax
