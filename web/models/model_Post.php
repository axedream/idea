<?php
class model_Post extends Model {

	public $input;				//входные данные
	public $DB = array();		//массив данных
	public $error;				//ошибки
	public $config;				//конфиг
	
	function __construct (){
		parent::__construct();
	}
  //get Input Data Valid - получение и проверка данных через базовый класс base
  //$area проверяемое поле, $model - регулярное выражение из конфига regexp в базовом классе base
  public function getIDV ($area,$model) {
    if (Post::gi()->getDataPostValid($area,$model)) return Post::gi()->dataPOST;
    else return FALSE;
    }//end getIDV

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
}

	
