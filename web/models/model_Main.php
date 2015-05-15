<?php
class model_Main extends Model {
	function __construct (){
		parent::__construct();
	}
	
	public function getTestTexData(){
		return ['data' => 'ok'];
	}	
	
	//функция содания пользователя
	public function setDBDataUSER($mass) {
		$mass['uid'] = DLL_DB::gi()->getUid();
		$mass['password'] = md5($mass['password']);
		echo $this->sigdDB ("set",'users','',$mass,'');
		}
	
	public function delDBDataUSER ($user,$key) {
		echo $this->sigdDB ("del",'users',$user,'',$key);		
		}
	
	public function updateDBDataUSER($mass,$area) {
		if (isset($mass['password'])) $mass['password']=md5($mass['password']);
		echo $this->sigdDB ("update",'users',$area,$mass,'');
		}
	
}
	
