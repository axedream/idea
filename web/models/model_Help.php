<?php
class model_Help extends Model {

	public $input;				//входные данные
	public $DB = array();		//массив данных
	public $error;				//ошибки
	public $config;				//конфиг
	
	function __construct (){
		parent::__construct();
	}
	
	//получаем данные из пост формы
	public function getInputData ($area,$model)	{
		if (Post::gi()->getDataPost($area,$model)) return Post::gi()->getDataPost($area,$model);
		else { $this->error="Is not right from method"; return false; };
		}

	//проверяем данные на соответстие шаблону
	public function getId ($id=false) {
		$this->config = App::gi()->config['regexp'];
		if ($id) {
			if (preg_match($this->config['uri']['id'], trim($id))) return true;
			}
		else return false;
		}

	//удаляем данные из базы
	public function del($id) {
		$this->table 		=	$this->DB['table'];
		$this->key			=	'del';
		$this->flag			=	'=';
		$this->area			=	['uid' => $id ];
		return $this->sigdDB ();
		}
		
	//получаем данные из базы
	public function select ($mass) {
		//в отсутсвия ограничения записей выводим все
    	$this->select	=	'all';
    	$this->key		=	'select';
    	$this->table	=	$this->DB['table'];
    	$this->mass		=	$mass;
    	return $this->sigdDB ();
        }

	//получаем данные из базы
	public function selectUid ($uid,$mass) {
       	$this->select	=	'where';
    	$this->key		=	'select';
    	$this->table	=	$this->DB['table'];
    	$this->mass		=	$mass;
    	$this->area		=	['uid' => $uid];
    	$this->flag		=	'=';
    	$this->prefix	=	'Easy';
    	return $this->sigdDB ();
		}

	public function updateDB($mass,$area) {
        $this->table	    =	$this->DB['table'];
	    $this->mass         =   $mass;
        $this->area         =   $area;
        $this->key          =   'update';
		return $this->sigdDB ();
		}


	//записываем данные в базу
	public function insert ($data) {
		$this->table		=	$this->DB['table'];
        DLL_DB::gi()->table =   $this->DB['table'];
		$this->key			=	'set';
		$mass['uid']		=	DLL_DB::gi()->getUid();		  //получаем уникальный UID (искуственный ключ)
        $mass['id']         =   DLL_DB::gi()->getId()+1;      //получаем последний ID (искуственный первичный ключ)
		$mass['textName'] 	=	$data;						  //данные по полю
		$this->mass 		=	$mass;
		return $this->sigdDB ();	                          //выполняем запрос
		}

	//записываем данные в базу (тупо но в данном случае уже нет времени переделывать поэтому insert2)!
	public function insert2 ($data) {
		$this->table		=	$this->DB['table'];
        DLL_DB::gi()->table =   $this->DB['table'];
		$this->key			=	'set';
		$mass['uid']		=	DLL_DB::gi()->getUid();		  //получаем уникальный UID (искуственный ключ)
        $mass['id']         =   DLL_DB::gi()->getId()+1;      //получаем последний ID (искуственный первичный ключ)
		$mass['key'] 	    =	$data['key'];
        $mass['textSurname']=   $data['s'];
        $mass['textName']   =   $data['n'];
        $mass['textMname']  =   $data['m'];
		$this->mass 		=	$mass;

        //echo "<pre>";
        //var_dump($this->mass);
		return $this->sigdDB ();	                          //выполняем запрос
		}

}

	
