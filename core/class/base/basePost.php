<?php
class Post extends Singleton{

	public $dataPOST;
	public $config;
	public $error;
	
	public function __construct() {
		$this->config = App::gi()->config['regexp'];
		}

  //area - get area in post form
  //rege - siarch in group 'base' regexp
  public function getDataPostValid($area=FALSE,$rege=FALSE) {


  	if (!$area) {
  	  $this->error = 'Not set AREA';
      return false;
      }

    //разворачиваем $rege
    if (is_array($rege)) foreach ($rege as $k => $v) {}


    if (isset($this->config[$k][$v])) {
      if (preg_match($this->config[$k][$v], trim($_POST[$area]))) { $this->dataPOST = trim($_POST[$area]); return $this->dataPOST; }
      else return FALSE;
      }//end rege
    else return FALSE;
    }


  //получение из пост формы и проерка валидации через класс rege + поле,
  //area указывает получаемое поле а rgege указывает общий класс гдесмотреть подкласс поля
	public function getDataPost($area=FALSE,$rege=FALSE){

	$keyRegExp = false;

	if (!$area) { $this->error = 'Not set AREA'; return false; }
	if ($rege) {
    foreach ($this->config as $k => $v) {
      if ($k==$rege) {
        if (isset($v[$area])) {
          $ReggExp = $v[$area];
          $keyRegExp=true;
          }
        } //end $k==$rege
      } //end foreach
    } //end rege

  //echo "REGEXP: ".$ReggExp."<br>";

	if (isset($_POST[$area])){
		if ($keyRegExp) {
			if (preg_match($ReggExp, trim($_POST[$area]))) {
				$this->dataPOST = trim($_POST[$area]);
				}
			else {$this->error = 'Not valid RegExp: '.$ReggExp; return false; }
			}
		else $this->dataPOST = trim($_POST[$area]);
		}
	else { $this->error = 'Not insert data from InPut'; return false;}

	return $this->dataPOST;
	}

}