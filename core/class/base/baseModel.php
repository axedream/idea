<?php
class Model extends Singleton{
	
	
	
	
	function __construct() {}

	//set,insert,get,delete DB (все поля должны быть, хотя бы "")
	function sigdDB ($key,$table,$area,$mass,$keys,$flagRequest=false) {

		if ($key=="set") {
			$request = DLL_DB::gi()->insertIntoDB($table,$mass);
			if ($request) $output=MySQLDB::gi()->setDBData($request);
			else return false;
			return $output;
			}
		if ($key=="del") {
			$request = DLL_DB::gi()->deleteDB ($table,$keys,$area);
			if ($request) $output=MySQLDB::gi()->setDBData($request);
			else return false;
			return $output;
			}
		if ($key=="update") {
			$request = DLL_DB::gi()->updateDB ($table,$mass,$area);
			if ($request) $output=MySQLDB::gi()->setDBData($request);
			else return false;
			return $output;			
			}
		if ($key=="select") {
			$request = DLL_DB::gi()->selectDB ($table,$keys,$mass,$area);
			if (!$flagRequest) $flagRequest = 'all';
			//echo "<pre>";
			//var_dump($request);
			if ($request) $output=MySQLDB::gi()->getDBData($request[$flagRequest]);
			else return false;
			return $output;			
			}
		}
}