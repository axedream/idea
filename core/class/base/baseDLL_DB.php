<?php
class DLL_DB extends MySQLDB {


	public function getUid () {
		return md5(date(DATE_RFC2822).rand(5,15000));
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
	$request = "SELECT `".$key."` FROM `".$table."` WHERE `".$p1."` ".$flag." '".$p2."';"; 
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