<?php
class model_Main extends Model {
	public $DB = array();
	
	function __construct (){
		parent::__construct();
		if (!isset($this->DB['table'])) $this->DB['table'] = "users";
	}
	
	public function getTestTexData(){
		return ['data' => 'ok'];
	}	
	
	//функция содания пользователя
	public function setDBDataUSER($mass) {
		$mass['uid'] = DLL_DB::gi()->getUid();
		$mass['password'] = md5($mass['password']);
		return $this->sigdDB ("set",$this->DB['table'],'',$mass,'');
		}
	
	public function updateDBDataUSER($mass,$area) {
		if (isset($mass['password'])) $mass['password']=md5($mass['password']);
		echo $this->sigdDB ("update",'users',$area,$mass,'');
		}
	
	public function delDBDataUSER ($user,$key) {
		return $this->sigdDB ("del",$this->DB['table'],$user,'',$key);		
		}
	
	public function getDBDataUSER($mass,$area,$keys) {
		return $this->sigdDB ("select",$this->DB['table'],$area,$mass,$keys);
		}
	
}
	
