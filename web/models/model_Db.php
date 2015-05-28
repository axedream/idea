<?php
class model_Db extends Model {

	public $input;				//входные данные
	public $DB = array();		//массив данных
	public $error;				//ошибки
	public $config;				//конфиг
	
	function __construct (){
		parent::__construct();
	}
	
	
	//удаляем данные из базы
	public function del($uid) {
		$this->key			=	'del';
		$this->flag			=	'=';
		$this->area			=	['uid' => $uid ];
		return $this->sigdDB ();
		}
		
	//получаем данные из базы
	public function select ($mass) {
		//в отсутсвия ограничения записей выводим все
    	$this->select	=	'all';
    	$this->key		=	'select';
    	$this->mass		=	$mass;
    	return $this->sigdDB ();
        }

	//получаем данные из базы по произвольному ключу
	public function selectKey ($mass,$key,$value) {
      $this->select	=	'where';
    	$this->key		=	'select';
    	$this->mass		=	$mass;
    	$this->area		=	[$key => $value];
    	$this->flag		=	'=';
    	return $this->sigdDB ();
		}
		
	//обновляем данные в таблице
	public function updateDB($mass,$area) {
	    $this->mass         =   $mass;
      $this->area         =   $area;
      $this->key          =   'update';
		return $this->sigdDB ();
		}


	//записываем данные в базу
	public function insert ($data) {
        DLL_DB::gi()->table =   $this->table;
		$this->key			=	'set';
		$mass			 	    =	$data;						          //данные по полю
		$mass['uid']		=	DLL_DB::gi()->getUid();		  //получаем уникальный UID (искуственный ключ)
    $mass['id']     = DLL_DB::gi()->getId()+1;    //получаем последний ID (искуственный первичный ключ)
		$this->mass 		=	$mass;
		return $this->sigdDB ();	                          //выполняем запрос
		}

}

	
