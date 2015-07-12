<?php
class MySQLDB extends Singleton {        //префикс для уникальности класса

    private     $dbh;
	public      $mysqlDBHost;
	public      $mysqlDBLogin;
	public      $mysqlDBPassword;
	public      $mysqlDBPort;
	public      $mysqlDBName;
	public      $mysqlDBHostname;
    public      $inputTable;             //отдельная таблица (в случае простых запросов)
    public      $inputData;              //отдельный ассоциативный массив (в случае простых запросов)
    public      $inputWhere;             //отдельный ассоциативный массив где (в случае простых запросов)
	public      $inputQuery;             //входящий запрос
	public      $DataDB;                 //исходящие данные
	public      $flagDB = "getDBData";



	public function __construct() {
		$this->mysqlDBHost 		= 	App::gi()->config['db']['host'];
-		$this->mysqlDBLogin		=	App::gi()->config['db']['user'];
-		$this->mysqlDBPassword	=	App::gi()->config['db']['password'];
-		$this->mysqlDBPort		=	App::gi()->config['db']['port'];
-		$this->mysqlDBName		=	App::gi()->config['db']['dbname'];
		$this->mysqlDBHostname	=	$this->mysqlDBHost.$this->mysqlDBPort;
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
		if (!$this->DataDB['error']['connect']['code']) {
			if (!$this->DataDB['error']['selectquery']['code']) {
				if (!$this->DataDB['error']['getdata']['code']) {
					return $this->DataDB;
					}
				else return '02';
				}
			else return '03';
			}
		else return '04';
		}

	//простая выборка из базы данных  query - Запрос; (подразумевает одиночный ответ)
	public function getDBDataEasy ($query="none") {
		if ($query!="none") $this->inputQuery =	$query;
		$this->flagDB = "getDBData";
		$this->runDB();
		//обработка ошибок
		if (!$this->DataDB['error']['connect']['code']) {
			if (!$this->DataDB['error']['selectquery']['code']) {
				if (!$this->DataDB['error']['getdata']['code']) {
					return $this->DataDB['data']['0'];	//возврат ассоциативного массива поле = значение;
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
			if (!$this->DataDB['error']['setdata']['code']) return '01';
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

    //---------------------------------------"быстрые" фкнуции для работы с базой данных (убираем данный функционал с DB_DLL)--------------------------------------//
    //если start = TRUE то запрос не выполняется (только готовится)


    //добавить запись в таблицу $this->inputTable массив данных array($row=>$deata)
    public function insertDBData ($start=FALSE) {
        $data = $this->add_magic_quotes($this->inputData);
        foreach ($data AS $k => $v){
            if(is_array($v)) $data[$k] = implode(",", $v);
            }
        $fields = array_keys($data);
        $this->inputQuery = "INSERT INTO $this->inputTable (`" . implode('`, `', $fields) . "`) VALUES ('" . implode("','", $data) . "')";

        if (!$start) return $this->setDBData();
        else return $this->inputQuery;
        }//end insertDBData

    //обновить записи в таблице
    public function updateDBData($start=FALSE) {
        $data = $this->add_magic_quotes($this->inputData);
        $bits = $wheres = array();
        //new dBug($data);
        foreach($data as $k => $v) {
            if(is_array($v)){
                $bits[] = "`$k` = '". implode(",",$v)."'";
            }else{
                $bits[] = "`$k` = '$v'";
            }
        }
        if(is_array($this->inputWhere)) {
            foreach($this->inputWhere as $k => $v) {
                if(is_array($v))
                {
                    $or = array();
                    foreach($v as $or_k => $or_v)
                        $or[] = "$or_k = '" . $this->add_magic_quotes($or_v) . "'";
                    $wheres[] = '('.implode(' OR ', $or).')';
                }
                else
                    $wheres[] = "$k = '" . $this->add_magic_quotes($v) . "'";
            }
        }
        else return FALSE;

        $this->inputQuery = "UPDATE $this->inputTable SET " . implode(', ', $bits) . ' WHERE ' . implode(' AND ', $wheres);

        if (!$start) return $this->setDBData();
        else return $this->inputQuery;
        }//end updateDBData

    public function deleteDBData($start=FALSE) {
        $bits = $wheres = array();
        if(is_array($this->inputWhere)) {
            foreach($this->inputWhere as $k => $v) {
                $wheres[] = $k . " = '" . $this->add_magic_quotes($v) . "'";
            }
        }
        else return FALSE;

        $this->inputQuery = "DELETE FROM " . $this->inputTable . " WHERE " . implode(' AND ', $wheres);

        if (!$start) return $this->setDBData();
        else return $this->inputQuery;
        }//end deleteDBData


    //--------------------------------------вспомогательные функции-------------------------------------------------//
    private function add_magic_quotes($array) {
        $mysqli = new mysqli($this->mysqlDBHostname, $this->mysqlDBLogin, $this->mysqlDBPassword, $this->mysqlDBName);
        foreach($array as $k => $v) {
            if(is_array($v)) $array[$k] = $this->add_magic_quotes($v);
            else $array[$k] = $mysqli->real_escape_string($v);
            }
        return $array;
        }

	//текущая дата на сервере
	public function getDateTime ($key=FALSE) {
		if ($key) return date('Y-m-d');
		else return date('Y-m-d H:i:s');
		}

} //end _mysqldb
?>