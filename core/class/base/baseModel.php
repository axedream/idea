<?php
class Model extends Singleton{
	
	public $key;
	public $table;
	public $area='';
	public $mass='';
	public $select='all';
	public $request='';
	public $output='';
	public $flag='';
	public $prefix = '';
  public $trable;
	
	
	
	function __construct() {}
	
	function sigdDB () {

		if ($this->key=="set") {
			DLL_DB::gi()->table = $this->table;
			DLL_DB::gi()->mass  = $this->mass;
			$this->request = DLL_DB::gi()->insertIntoDB();
			if (DLL_DB::gi()->request) return $this->output=MySQLDB::gi()->setDBData($this->request);
			else return false;
			}
		if ($this->key=="del") {
			DLL_DB::gi()->table		=	$this->table;
			DLL_DB::gi()->area		=	$this->area;
			DLL_DB::gi()->flag		=	$this->flag;
			$this->request = DLL_DB::gi()->deleteDB ();
			if ($this->request) return $this->output=MySQLDB::gi()->setDBDataEasy($this->request);
			else return false;
			}
		if ($this->key=="update") {
			DLL_DB::gi()->table		=	$this->table;
			DLL_DB::gi()->mass	    =	$this->mass;
			DLL_DB::gi()->area	    =	$this->area;
			$this->request          =   DLL_DB::gi()->updateDB();

            $metod = 'setDBData'.$this->prefix;
			if ($this->request) return $this->output=MySQLDB::gi()->$metod($this->request);
			else return false;
			}
		if ($this->key=="select") {
			DLL_DB::gi()->table		=	$this->table;
			DLL_DB::gi()->select	=	$this->select;
			DLL_DB::gi()->mass		=	$this->mass;
			DLL_DB::gi()->area		=	$this->area;
			DLL_DB::gi()->flag		=	$this->flag;
      DLL_DB::gi()->trable  = $this->trable;
			$this->request = DLL_DB::gi()->selectDB ();
			$metod = 'getDBData'.$this->prefix;
			$this->output=MySQLDB::gi()->$metod($this->request);
			if ($this->request) return $this->output=MySQLDB::gi()->$metod($this->request);
			else return false;
			}
		}
}