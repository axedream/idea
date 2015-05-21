<?php
class MySQLDB extends Singleton {
	
	public $mysqlDBHost;
	public $mysqlDBLogin;
	public $mysqlDBPassword; 
	public $mysqlDBPort; 
	public $mysqlDBName;
	public $mysqlDBHostname;
	public $inputQuery;
	public $DataDB;
	public $flagDB = "getDBData";

	
	
	public function __construct() {
		$this->mysqlDBHost 		= 	eA(App::gi()->config)->db->host;
		$this->mysqlDBLogin		=	eA(App::gi()->config)->db->user;
		$this->mysqlDBPassword	=	eA(App::gi()->config)->db->password;
		$this->mysqlDBPort		=	eA(App::gi()->config)->db->port;
		$this->mysqlDBName		=	eA(App::gi()->config)->db->dbname;
		$this->mysqlDBHostname	=	$this->mysqlDBHost.":".$this->mysqlDBPort;
	}
	
	
	protected function runDB () {
	unset($this->DataDB);
	$flagNum = 0;
	
	if ($this->inputQuery) $mysqli = new mysqli($this->mysqlDBHostname, $this->mysqlDBLogin, $this->mysqlDBPassword, $this->mysqlDBName);
	else {	
		$this->DataDB['error']['disconnect']['status'] 		= false; 
		$this->DataDB['error']['disconnect']['code'] 		= 10; 
		$this->DataDB['error']['disconnect']['data'] 		= "db query is broken"; 		
		}
	
	if (!mysqli_connect_errno()) {
		$dbConnect = mysqli_connect($this->mysqlDBHostname, $this->mysqlDBLogin, $this->mysqlDBPassword, $this->mysqlDBName);
		$this->DataDB['error']['connect']['status'] 	= true; 
		$this->DataDB['error']['connect']['code'] 		= false; 
		
		//--------------------------------------flag GET-----------------------------------------------//
		if ($this->flagDB == "getDBData"){
		//echo "<br><br>!!!GET!!!<br><br>";
			$dbQuery = $dbConnect->query($this->inputQuery);
			if ($dbQuery) {
				$this->DataDB['error']['selectquery']['status'] 	= true; 
				$this->DataDB['error']['selectquery']['code'] 		= false; 
				$getData = $dbQuery->fetch_assoc();
				if ($getData!=null) {
					$this->DataDB['error']['getdata']['status'] 	= true; 
					$this->DataDB['error']['getdata']['code'] 		= false; 
					$this->DataDB['data'][$flagNum]= $getData;
					while ($getData = $dbQuery->fetch_assoc()){
						++$flagNum;
						$this->DataDB['data'][$flagNum] = $getData;
						}
					}
				else {
					$this->DataDB['error']['getdata']['status'] 	= false; 
					$this->DataDB['error']['getdata']['code'] 		= 11; 
					$this->DataDB['error']['getdata']['data'] 		= "can not get DATA"; 					
					} //GET DATA
				}
			else {
				$this->DataDB['error']['selectquery']['status'] 	= false; 
				$this->DataDB['error']['selectquery']['code'] 		= 12; 
				$this->DataDB['error']['selectquery']['data'] 		= "can not select QUERY'"; 					
				} //$dbQuery	
		}
		//--------------------------------------flag GET-----------------------------------------------//
		
		
		
		//--------------------------------------flag SET-----------------------------------------------//
		if ($this->flagDB == "setDBData") {
		//echo "<br><br>!!!SET!!!<br><br>";
			if ($dbConnect->query($this->inputQuery)){
				$this->DataDB['error']['setdata']['status'] 	= true; 
				$this->DataDB['error']['setdata']['code'] 		= false; 
			}
			else {
				$this->DataDB['error']['setdata']['status'] 	= false; 
				$this->DataDB['error']['setdata']['code'] 		= 14; 
				$this->DataDB['error']['setdata']['data'] 		= "can not set DATA"; 
			}
		}
		//-----------------------------------END flag SET-----------------------------------------------//
		
		if ($mysqli->close())	{
			$this->DataDB['error']['disconnect']['status'] 	= true; 
			$this->DataDB['error']['disconnect']['code'] 	= false; 
		} 
		else {
			$this->DataDB['error']['disconnect']['status'] 	= false; 
			$this->DataDB['error']['disconnect']['code'] 		= 13; 
			$this->DataDB['error']['disconnect']['data'] 		= "db close is not successful"; 
			}	
			
		} //end CONNECT
	else {
		$this->DataDB['error']['connect']['status'] 	= false; 
		$this->DataDB['error']['connect']['code'] 		= 10; 
		$this->DataDB['error']['connect']['data'] 		= "connect lost"; 
		}
		
		$this->DataDB['count']	=	$flagNum+1;
	}
	
	//выборка из базы данных
	public function getDBData ($query="none") {
		if ($query!="none") $this->inputQuery =	$query;
		$this->flagDB = "getDBData";
		$this->runDB();
		
		//обработка ошибок
		if (!eA($this->DataDB)->error->connect->code) {
			if (!eA($this->DataDB)->error->selectquery->code) {
				if (!eA($this->DataDB)->error->getdata->code) {
					return $this->DataDB;
					}
				else return '01';
				}
			else return '02';
			}
		else return '03';		
		}

	//простая выборка из базы данных  query - Запрос; (подразумевает одиночный ответ)
	public function getDBDataEasy ($query="none") {
		if ($query!="none") $this->inputQuery =	$query;
		$this->flagDB = "getDBData";
		$this->runDB();
		
		//обработка ошибок
		if (!eA($this->DataDB)->error->connect->code) {
			if (!eA($this->DataDB)->error->selectquery->code) {
				if (!eA($this->DataDB)->error->getdata->code) {
					return $this->DataDB['data'][0];	//возврат ассоциативного массива поле = значение;
					}
				else return false;
				}
			else return false;
			}
		else return false;		
		}
		
		
	//запись в базу данных
	public function setDBData($query="none") {
		if ($query!="none") $this->inputQuery =	$query;
		$this->flagDB = "setDBData";
		$this->runDB();
		//обработка ошибок
		if (!$this->DataDB['error']['connect']['code']) {
			if (!$this->DataDB['error']['setdata']['code']) return true;
			else return '02';
			}
		else return '03';
		}
	
	//запись в базу данных
	public function setDBDataEasy($query="none") {
		if ($query!="none") $this->inputQuery =	$query;
		$this->flagDB = "setDBData";
		$this->runDB();
		//обработка ошибок
		if (!$this->DataDB['error']['connect']['code']) {
			if (!$this->DataDB['error']['setdata']['code']) return true;
			else return false;
			}
		else return false;
		}	
}