<?php
class Shorturl extends Singleton{

    public $key;        //key for secure
    public $url;        //url for created
	public $key_ss;		//session key
	public $ip;			//ip adreess of thit user
	public $request;	//request from database
	public $dateTime;	//now date
	public $table;		//base table url
	public $error;		//mass from error

	//$this->url_code = base_convert($this->url,10, 36);
	
	public function __construct($key) {
		$this->table = "xiag_sl";
		$this->setVar();
		}

	public function setUrl () {
		if ( $this->checkKey() ) {
			if ( $this->checkHesh() ) { $this->error['setUrl'] = 'checkHesh'; return FALSE; }
			else {
				if ($this->checkDateIp()) { $this->error['setUrl'] = 'checkDateIp'; return FALSE; } //need make function -> error (in the future)
				else {
					//if all checked we can create line with our data
					$lastGEN = $this->getLastGEN();
					//echo $lastGEN;
					$lastGEN ++; $gen = base_convert($lastGEN,10, 36);
					echo $gen;
					}
				}//end checkHesh
			}
		else {  $this->error['setUrl'] = 'checkKey'; return FALSE; } //checkKey
		}//end setUrl
		
		
	private function setVar() {
		$this->dateTime = MySQLDB::gi()->getDateTime();
		$this->ip = $_SERVER["REMOTE_ADDR"];
		
		$this->key_ss = (isset ($_SESSION['key'])) ?  $_SESSION['key'] : 0 ;

		$this->request['hesh']['data'] 	= "SELECT * FROM $this->table WHERE hesh = '".md5($this->url['input'])."'";		
		$this->request['hesh']['count']	= "SELECT COUNT(*) AS CC FROM $this->table WHERE hesh = '".md5($this->url['input'])."'";		
		
		$this->request['ip']['count'] 	= "SELECT COUNT(*) AS CC FROM $this->table WHERE dip = '".$this->ip."' AND TO_SECONDS(NOW()) - TO_SECONDS(dcreate) <= 120 ";
		
		$this->request['lastDataLine']['data']  = "select * from $this->table where id = (select max(id) from $this->table)";
		$this->request['lastDataLine']['count'] = "select COUNT(*) AS CC from $this->table where id = (select max(id) from $this->table)";
		}

	//return last GEN (from 10)
	function getLastGEN() {
		MySQLDB::gi()->inputQuery = $this->request['lastDataLine']['count']; MySQLDB::gi()->getDBData();
		if (MySQLDB::gi()->DataDB['data']['0']['CC']=="0") return "10000";
		else return base_convert(MySQLDB::gi()->DataDB['data']['0']['gen'],36, 10);
		}

	//FASE if key assecced, else return FALSE
	private function checkKey() {
		if ($this->key == $this->key_ss) return TRUE;
		else return FALSE;	
		}
		
	//return FALSE if not found hesh, TRUE if found and set $this->url['output'] fouded url
    public function checkHesh() {
		MySQLDB::gi()->inputQuery = $this->request['hesh']['count']; MySQLDB::gi()->getDBData();
		if (MySQLDB::gi()->DataDB['data']['0']['CC']!="0") {
			MySQLDB::gi()->inputQuery = $this->request['hesh']['data']; MySQLDB::gi()->getDBData();
			$this->url['output'] = MySQLDB::gi()->DataDB['data']['0']['real'];
			return TRUE;
			}//end count hesh
		else return FALSE;
		}//end checkData
	
	//retrun -> FALSE if not found row, -> TRUE  if found 
	public function checkDateIp() {
		MySQLDB::gi()->inputQuery = $this->request['ip']['count']; MySQLDB::gi()->getDBData();
		if (MySQLDB::gi()->DataDB['data']['0']['CC']!="0") return TRUE;
		else return FALSE;
		}

	//feature unit test
	function unitTest() {
		echo "test is successfuled";
		}
	
}