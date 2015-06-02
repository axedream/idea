<?php
class DLL_DB extends MySQLDB {

	public $dataDB;
	public $key;
	public $table;
	public $area;
	public $mass;
	public $select='all';
	public $request;
	public $output;
	public $flag;
  public $trable=FALSE;

	//дополнительные данные для формирования постоянной части таблицных записей
	public function getHelpData () {
		if (!isset($this->table)) return false;
		$this->dataDB['table']	=	$this->table;           //текущая таблица
		$this->dataDB['uid']	  =	$this->getUid();        //uid записи
		$this->dataDB['id']		  =	$this->getId($this->table)+1; //id записи
		$this->dataDB['DT']		  =	$this->getDateTime();   //полная дата время
		$this->dataDB['DA']		  =	$this->getDateTime(1);  //только дата
		$this->dataDB['user']	  =	User::gi()->user;       //имя текущего пользователя
		$this->dataDB['group']	=	User::gi()->group;      //группа текущего пользователя
		$this->dataDB['IP']		  =	User::gi()->rip;        //ip текущего пользователя
		$this->dataDB['active']	=	true;                   //запись активна
		}

	//уникальный UID
	public function getUid() {
		return md5(date(DATE_RFC2822).rand(5,15000));
		}

	//последний ID в таблице
	public function getId() {
		$this->request	=	"SELECT id FROM `".$this->table."` ORDER BY id DESC LIMIT 1;";
		$data = MySQLDB::gi()->getDBDataEasy($this->request);
		return $lastId = ($data) ? $lastId = $data['id'] : false ;
		}

	//текущая дата на сервере если key установлен то возвращается датавремя если нет только дата
	public function getDateTime ($key=FALSE) {
		if ($key) return date('Y-m-d');
		else return date('Y-m-d H:i:s');
		}

	//$mass - поля, которые ищем, $table - таблица базы данных, $area - поле = > значение по которому ищей 1 шт.
	public function selectDB () {
	if ($this->select!='all')
		{
		if (count($this->area)==1) {
				foreach ($this->area as $k  => $v) {
					$p1 = $k; $p2 = $v;
				}
			}
		}

	if (count($this->mass)>0) {
		for ($i=0;$i<count($this->mass);$i++) {
			if (!isset($key)) $key = $this->mass[$i];
			else {
			    if ($this->trable) $key = $key.",".$this->mass[$i];
			    else $key = $key."`,`".$this->mass[$i];
          }
			}
		}
	if ($this->select=="all") 	$this->request	=	"SELECT `".$key."` FROM `".$this->table."` ;";

  if ($this->select=="where") {
    if ($this->trable)  $this->request	=	"SELECT ".$key." FROM `".$this->table."` WHERE `".$p1."` ".$this->flag." '".$p2."';";
    else   $this->request	=	"SELECT `".$key."` FROM `".$this->table."` WHERE `".$p1."` ".$this->flag." '".$p2."';";
    }

	return $this->request;
	}
	
	//$mass - поле => значение, $table - таблица базы данных 
	public function insertIntoDB () {
		foreach ($this->mass as $k  => $v) {
			if (!isset($value))$value = $v;
			else $value = $value."','".$v;
			if (!isset($key))$key = $k;
			else $key = $key."`,`".$k;		
			}
			
		$value 	= "('".$value."')";
		$key	= "(`".$key."`)";
		
		$this->request = "INSERT INTO `".$this->table."` ".$key." VALUE ".$value.";";
		return $this->request;
		}
		
	//$mass - поле = > значение, $table - таблица, $area - поле = > значение по которому ищей 1 шт. 
	public function updateDB () {
		if (count($this->area)==1) {
				foreach ($this->area as $k  => $v) {
					$p1 = $k; $p2 = $v;
				}
			}
		else return false;


		foreach ($this->mass as $k  => $v) {
			if (!isset($key))  $key = "`".$k."` = '".$v."'";
			else $key = $key.",`".$k."` = '".$v."'";
			}	
		$this->request = "UPDATE `".$this->table."` SET ".$key." WHERE `".$p1."` = '".$p2."';";
		return $this->request;
		}
		
	//$mass - поле = > значение, $table - таблица, $area - поле = > значение по которому ищей 1 шт. 		
	public function deleteDB () {
		if (count($this->area)==1) {
				foreach ($this->area as $k  => $v) {
					$p1 = $k; $p2 = $v;
				}
			}
		else return false;
			
		$this->request = "DELETE FROM `".$this->table."` WHERE `".$p1."` ".$this->flag." '".$p2."';"; 
		return $this->request;		
		}
}