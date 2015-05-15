<?php
class Model extends Singleton{
	
	
	
	
	function __construct() {}

	//set,insert,get,delete DB (все поля должны быть, хотя бы "")
	function sigdDB ($key,$table,$area,$mass,$keys) {

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
			$request = DLL_DB::gi()->updateDB ($table,$area,$mass);
			if ($request) $output=MySQLDB::gi()->setDBData($request);
			else return false;
			return $output;			
			}
		}
}