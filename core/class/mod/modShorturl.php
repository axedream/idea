<?php
class Shorturl extends Singleton{

    public $key;        //key for secure
    public $url;        //url input
    public $input_url;  //url not validate
    public $hesh_url;   //url if use hesh
	public $key_ss;		//session key
	public $ip;			//ip adreess of thit user
	public $request;	//request from database
	public $dateTime;	//now date
	public $table= "xiag_sl";//base table url
    public $output;     //output data massive

	//$this->url_code = base_convert($this->url,10, 36);

	public function __construct() {
		}

	public function setUrl () {
   		$this->setVar();

		if ( $this->checkKey() ) {
			if ( $this->checkHesh() ) {
			        $this->output['type']       =   'dataOutput_hesh';
                    $this->output['message']    =   $this->hesh_url;
                    $this->output['error']      =   'no';
                    }
			else {
				if ($this->checkDateIp()) {
                        $this->output['type']       =   'checkDateIp';
				        $this->output['message']    =   'You too often try to generate the link. Admissible interval 2 minutes! Wait 2 minutes and try again.';
                        $this->output['error']      =   'yes';
                        } //need make function -> error (in the future)
				else {
					//if all checked we can create line with our data
					$lastGEN = $this->getLastGEN();
					//return $lastGEN;
					$lastGEN ++; $gen = base_convert($lastGEN,10, 36);
                    //mysql request from input line
                    //echo md5($this->url);
                    MySQLDB::gi()->inputTable = $this->table;
                    MySQLDB::gi()->inputData = [
                            'hesh'  => md5($this->url),
                            'gen'   => $gen,
                            'real'  => $this->url,
                            'dip'   => $this->ip
                            ];
                    MySQLDB::gi()->insertDBData();
					$this->output['type']       =   'dataOutput_gen' ;
					$this->output['message']    =   $gen ;
                    $this->output['error']      =   'no';
					}
				}//end checkHesh
			}
		else {
            $this->output['type']       =   'checkKey';
            $this->output['message']    =   'Error of generation of a protective key. The page became outdated. Proprobuyte to reboot this page and to generate the link.';
            $this->output['error']      =   'yes';
            } //checkKey
		}//end setUrl


	private function setVar() {
		$this->dateTime = MySQLDB::gi()->getDateTime();
		$this->ip = $_SERVER["REMOTE_ADDR"];

        if ( !preg_match(App::gi()->config['regexp']['uri']['full_url'],$this->input_url) ) {
		    $this->output['type']       =   'checkUrl' ;
            $this->output['message']    =   'Not the correct address of a link is entered. Change an adrsa and repeat generation procedure.';
            $this->output['error']      =   'yes';
            }
        else $this->url = $this->input_url;


		$this->key_ss = (isset ($_SESSION['key'])) ?  $_SESSION['key'] : 0 ;

		$this->request['hesh']['data'] 	= "SELECT * FROM $this->table WHERE hesh = '".md5($this->url)."'";
		$this->request['hesh']['count']	= "SELECT COUNT(*) AS CC FROM $this->table WHERE hesh = '".md5($this->url)."'";

		$this->request['ip']['count'] 	= "SELECT COUNT(*) AS CC FROM $this->table WHERE dip = '".$this->ip."' AND TO_SECONDS(NOW()) - TO_SECONDS(dcreate) <= 120 ";

		$this->request['lastDataLine']['data']  = "select * from $this->table where id = (select max(id) from $this->table)";
		$this->request['lastDataLine']['count'] = "select COUNT(*) AS CC from $this->table where id = (select max(id) from $this->table)";
		}

	//return last GEN (from 10)
	function getLastGEN() {
		MySQLDB::gi()->inputQuery = $this->request['lastDataLine']['count'];
        MySQLDB::gi()->getDBData();
		if (MySQLDB::gi()->DataDB['data']['0']['CC']=="0") return "10000";
		else{
            MySQLDB::gi()->inputQuery = $this->request['lastDataLine']['data'];
            MySQLDB::gi()->getDBData();
            $nn = MySQLDB::gi()->DataDB['data']['0']['gen'];
            return base_convert($nn,36, 10);
            }
		}

	//FASE if key assecced, else return FALSE
	private function checkKey() {
		if ($this->key == $this->key_ss) return TRUE;
		else return FALSE;	
		}
		
	//return FALSE if not found hesh, TRUE if found and set $this->url['output'] fouded url
    public function checkHesh() {
		MySQLDB::gi()->inputQuery = $this->request['hesh']['count'];
        MySQLDB::gi()->getDBData();
        MySQLDB::gi()->inputQuery;
		if (MySQLDB::gi()->DataDB['data']['0']['CC']!="0") {
			MySQLDB::gi()->inputQuery = $this->request['hesh']['data'];
            MySQLDB::gi()->getDBData();
			$this->hesh_url = MySQLDB::gi()->DataDB['data']['0']['gen'];
			return TRUE;
			}//end count hesh
		else return FALSE;
		}//end checkData

	//retrun -> FALSE if not found row, -> TRUE  if found
	public function checkDateIp() {
		MySQLDB::gi()->inputQuery = $this->request['ip']['count'];
        MySQLDB::gi()->getDBData();
		if (MySQLDB::gi()->DataDB['data']['0']['CC']!="0") return TRUE;
		else return FALSE;
		}

	//feature unit test
	function unitTest() {
		echo "test is successfuled";
		}
	
}