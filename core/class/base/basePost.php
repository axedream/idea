<?php
class Model extends Singleton{

	public $DataPOST;
	
	function __construct() {}
	
	/*
	@	обрабатываем данные из формы
	@	получаем обратно массив 
	@	ошибки
	@	'error	=> 
	@			'данные' => 
	@				'status'		=>	'true/false - в зависимости от наличие ошибок'
	@				'data'			=>	'описание ошибки'
	@				'code'			=>	'код ошибки (по уровню вложенности проверок)'
	@	данные
	@	'data'	=> $rData	
	@			'данные' => 
	@				'method'	=>	'метод передачи - POST'
	@				'value'		=>	'значение компаненты (поля)'
	*/		
	//функция проверки поля POST формы (area - наименование поля)
	public function getPostData($area="none"){

	//прорабатываем массив
	$i="0"; $flag="0";
	foreach (eA($App::gi()->config)->regexp->user as $k => $v) {
		$i++;
		if (eA($App::gi()->config)->regexp->user->$area==$k) $flag=1;
		}
	
	if ($i!="0" && $flag!="0" && $area!="none") $ReggExp = eA($App::gi()->config)->regexp->user->$area;
	else return false;
	
	//echo $ReggExp."<br>";
	//echo $_POST[$area]."<br>";

	//логин
	if (isset($_POST[$area])) {
		if (preg_match($ReggExp, trim($_POST[$area]))) {
			$this->DataPOST  ['data'][$area]['method'] 		= 'post'; 
			$this->DataPOST  ['data'][$area]['value']		= trim($_POST[$area]);
			$this->DataPOST  ['error'][$area]['status'] 	= false;  
			$this->DataPOST  ['error'][$area]['code'] 		= 0;
			}
		else {
			$this->DataPOST ['error'][$area]['status'] 		= true;
			$this->DataPOST ['error'][$area]['data'] 		= "false of Reg_Exp";
			$this->DataPOST ['error'][$area]['code'] 		= 2;
			}
		}
	else {
			$this->DataPOST ['error'][$area]['status'] 		= true;
			$this->DataPOST ['error'][$area]['data'] 		= "not get data ".$area." of POST method";
			$this->DataPOST ['error'][$area]['code'] 		= 1;
		}
//echo "<pre>";
	//var_dump ($this->DataPOST);
	return $this->DataPOST;
	}

}