<?php
class DLL_DB extends MySQLDB {

	public $dataDB;

	//дополнительные данные для формирования постоянной части таблицных записей
	public function getHelpData ($table) {
		if (!isset($table)) return false;
		$this->dataDB['table']	=	$table;
		$this->dataDB['uid']	=	$this->getUid();
		$this->dataDB['id']		=	$this->getId($table)+1;
		$this->dataDB['DT']		=	$this->getDateTime();
		$this->dataDB['DA']		=	$this->getDateTime(1);
		$this->dataDB['user']	=	$_SESSION['user'];
		$this->dataDB['group']	=	$_SESSION['group'];
		$this->dataDB['IP']		=	App::gi()->rip;
		$this->dataDB['active']	=	true;
		}

	//уникальный UID
	public function getUid () {
		return md5(date(DATE_RFC2822).rand(5,15000));
		}
	
	//последний ID в таблице
	public function getId($table) {
		$request	=	"SELECT id FROM `".$table."` ORDER BY id DESC LIMIT 1;";
		$data = MySQLDB::gi()->getDBDataEasy($request);
		return $lastId = ($data) ? $lastId = $data['id'] : false ;
		}

	//текущая дата на сервере если key установлен то возвращается датавремя если нет только дата
	public function getDateTime ($key=false) {
		if (!$key) return date('Y-m-d H:i:s');
		else return date('Y-m-d');
		}
	
	
	
	//$mass - поля, которые ищем, $table - таблица базы данных, $area - поле = > значение по которому ищей 1 шт.	
	public function selectDB ($table,$flag,$area,$mass) {
	if (count($area)==1) {
			foreach ($area as $k  => $v) {
				$p1 = $k; $p2 = $v;
			}
		}
	if (count($mass)>0) {
		for ($i=0;$i<count($mass);$i++) {
			if (!isset($key)) $key = $mass[$i];
			else $key = $key."`,`".$mass[$i];
			}			
		}
	$request['where']	=	"SELECT `".$key."` FROM `".$table."` WHERE `".$p1."` ".$flag." '".$p2."';"; 
	$request['all']		=	"SELECT `".$key."` FROM `".$table."` ;"; 

	return $request;
	}
	
	//$mass - поле => значение, $table - таблица базы данных 
	public function insertIntoDB ($table,$mass) {
		foreach ($mass as $k  => $v) {
			if (!isset($value))$value = $v;
			else $value = $value."','".$v;
			if (!isset($key))$key = $k;
			else $key = $key."`,`".$k;		
			}
			
		$value 	= "('".$value."')";
		$key	= "(`".$key."`)";	
		
		$request = "INSERT INTO `".$table."` ".$key." VALUE ".$value.";"; 
		return $request;
		}
		
	//$mass - поле = > значение, $table - таблица, $area - поле = > значение по которому ищей 1 шт. 
	public function updateDB ($table,$area,$mass) {
		if (count($area)==1) {
				foreach ($area as $k  => $v) {
					$p1 = $k; $p2 = $v;
				}
			}
		else return false;
		
		foreach ($mass as $k  => $v) {
			if (!isset($key))  $key = "`".$k."` = '".$v."'";
			else $key = $key.",`".$k."` = '".$v."'";
			}	
		$request = "UPDATE `".$table."` SET ".$key." WHERE `".$p1."` = '".$p2."';"; 
		return $request;
		}
		
	//$mass - поле = > значение, $table - таблица, $area - поле = > значение по которому ищей 1 шт. 		
	public function deleteDB ($table,$flag,$area) {
		if (count($area)==1) {
				foreach ($area as $k  => $v) {
					$p1 = $k; $p2 = $v;
				}
			}
		else return false;
			
		$request = "DELETE FROM `".$table."` WHERE `".$p1."` ".$flag." '".$p2."';"; 
		return $request;		
		}
}