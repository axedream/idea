<?php
class Help extends Controller {
	
	public $conf;		//файл конфигурации меню
	public $ac;			//действие пользователя без префикса
	public $conten;		//формирует содержимое странички
	public $id;			//динамические ID
	
	public function __construct () {
		parent::__construct();
		$this->ac = App::gi()->ac;
		$this->id = Router::gi()->id;
		$this->conf['menu'] = include VIEW.'help/conf.php';
		if ($this->ac!='index') $this->conf['menu'][App::gi()->ac]['active'] = true;
		$this->createMenu();
		}

	public function __destruct () {
		$this->view->show('help/body',$this->content);
		}

    public function mess($text,$type=false) {
        if ($type)   $this->content['message'] = $this->view->show('help/success',['text' => $text],1);
        else $this->content['message'] = $this->view->show('help/error',  ['text' => $text],1);
        }

    public function buttonAdd($type) {
        if ($type=="city") {
            $buttonAdd = $this->view->show('help/buttonAdd',['helpULRAdd' => URL.'help/city/add'],1);
			$this->content['header'] = $this->view->show('help/header',['headerName' => 'Города', 'headerButton' => $buttonAdd],1);
            }
        if ($type=="area") {
            $buttonAdd = $this->view->show('help/buttonAdd',['helpULRAdd' => URL.'help/area/add'],1);
			$this->content['header'] = $this->view->show('help/header',['headerName' => 'Районы', 'headerButton' => $buttonAdd],1);
            }
        if ($type=="street") {
            $buttonAdd = $this->view->show('help/buttonAdd',['helpULRAdd' => URL.'help/street/add'],1);
			$this->content['header'] = $this->view->show('help/header',['headerName' => 'Улицы', 'headerButton' => $buttonAdd],1);
            }
        if ($type=="snm") {
            $buttonAdd = $this->view->show('help/buttonAdd',['helpULRAdd' => URL.'help/snm/add'],1);
			$this->content['header'] = $this->view->show('help/header',['headerName' => 'ФИО', 'headerButton' => $buttonAdd],1);
            }
        }

	public function createMenu () {
		foreach ($this->conf['menu'] as $k => $v)
			{
			$data['url'] = URL.$v['url'];
			$data['active'] = ($v['active']) ? 'active' : '';
			$data['text'] = $v['text'];
			$cont = $cont.$this->view->show('help/buttonLeft',$data,1);
			}
		$this->content['button'] = $cont;
		$this->view->show('help/menu',$this->content);
		}



//-------------------------------------------------CITY---------------------------------------------//
	private function createTableCity () {
	    model_Help::gi()->DB['table'] = 'etagi_helpCity';
		//запрос
		$status = model_Help::gi()->select(['textName','uid']);
		if ( $status=="02" ) $this->mess('Таблица городов пуста');
		else {
			$data = model_Help::gi()->select(['textName','uid'])['data'];	//получаем данные из модели для построения списка городов
			if (is_array($data)) {
				for ($i=0;$i<count($data);$i++) {
					//фомируем строку (массив данных)
					$dataCity = ['cityName' => $data[$i]['textName'], 'urlEdit'=>URL.'help/city/edit/'.$data[$i]['uid'],'urlDel'=>URL.'help/city/del/'.$data[$i]['uid']];
					$lineCity = $lineCity.$this->view->show('help/city/formCity',$dataCity,1);
					}
				$this->content['table'] = $this->view->show('help/city/formListCity',['formCity'=>$lineCity],1);
				}
			}
		}

	public function action_city() {
	    model_Help::gi()->DB['table'] = 'etagi_helpCity';
		//до дефолту
		if (!$this->id['0']) {
            $this->buttonAdd('city');
			$this->createTableCity();
			}

		//форма добавления города
		if ($this->id['0']=="add"){
			$formInputCity = $this->view->show('help/city/formInputCity',['urlAction' => URL.'help/city/request/add'],1);
			$this->content['header'] = $this->view->show('help/header',['headerName' => 'Города', 'headerButton' => $formInputCity],1);
			}


		//проверка добавления/редактирование города
		if ($this->id['0']=="request") {
            //ADD
			if ($this->id['1']=="add"){
				$this->buttonAdd('city');
				if (model_Help::gi()->getInputData ('inputCity','help')){					//Успешно пост форма
					$inputCity = model_Help::gi()->getInputData ('inputCity','help');		//Получаем весь список городов (по идее нужно добавить LIMIT и сделать листинг)
                    $out = model_Help::gi()->insert($inputCity);
					if ($out=="01") {
					    $this->mess('Запись успешно добавлена', 1);
						$this->createTableCity();
						}
					else {
					  $this->mess('Такой город уже существует');
                      $this->createTableCity();
                      }
				}
				else $this->mess('Ошибка ввода, попробуйте повторить ввод');
				}//end request ADD
            //EDIT
        	if ($this->id['1']=="edit") {
        	    $dataInputCity = model_Help::gi()->getInputData('inputCity','help');
                      if ($dataInputCity){
                          $uidInputCity = $this->id[2];
                          $out = model_Help::gi()->updateDB(['textName'=> $dataInputCity],['uid'=>$uidInputCity]);
                          if ($out=='01') {
                                $this->mess('Запись успешно обновлена',1);
                                $this->createTableCity();
                                }
                          else {
                                $this->mess('Такой город уже существует');
                                $this->createTableCity();
                                }
                          }
                      else $this->mess('Ошибка ввода, попробуйте повторить ввод');
        	    }//end request EDIT
            }//end request

  		//удаление
  		if ($this->id['0']=='del') {
  			if (model_Help::gi()->getId($this->id[1])) {
  				//запрос на удаление
  				if (model_Help::gi()->del($this->id[1])) $this->mess('Запись успешно удалена',1);
  				else $this->mess('Запрос отклонен');
  				$this->createTableCity();
  				}
  			else  $this->mess('Ошибка передачи параметров');
  			}
  		//редактирование
  		if ($this->id['0']=='edit') {
      		$data = model_Help::gi()->selectUid($this->id[1],['textName','uid']);
      		if ($data!="02" or $data!="03") {
      			$formEditCity = $this->view->show('help/city/formEditCity',['value' => $data['textName'],'urlAction' => URL.'help/city/request/edit/'.$data['uid']],1);
      			$this->content['header'] = $this->view->show('help/header',['headerName' => 'Города', 'headerButton' => $formEditCity],1);
      			}
      	    }

    }
//---------------------------------------------END CITY---------------------------------------------//
//-------------------------------------------------AREA---------------------------------------------//
	private function createTableArea () {
	    model_Help::gi()->DB['table'] = 'etagi_helpArea';
		$status = model_Help::gi()->select(['textName','uid']);
		if ( $status=="02" ) $this->mess('Таблица районов пуста');
		else {
			$data = $status['data'];
			if (is_array($data)) {
				for ($i=0;$i<count($data);$i++) {
					$dataArea = ['areaName' => $data[$i]['textName'], 'urlEdit'=>URL.'help/area/edit/'.$data[$i]['uid'],'urlDel'=>URL.'help/area/del/'.$data[$i]['uid']];
					$lineArea = $lineArea.$this->view->show('help/area/formArea',$dataArea,1);
					}
				$this->content['table'] = $this->view->show('help/area/formListArea',['formArea'=>$lineArea],1);
				}
			}
		}

	public function action_area() {
	    model_Help::gi()->DB['table'] = 'etagi_helpArea';
		//до дефолту
		if (!$this->id['0']) {
            $this->buttonAdd('area');
			$this->createTableArea();
			}
		//форма добавления района
		if ($this->id['0']=="add"){
			$formInputArea = $this->view->show('help/area/formInputArea',['urlAction' => URL.'help/area/request/add'],1);
			$this->content['header'] = $this->view->show('help/header',['headerName' => 'Районы', 'headerButton' => $formInputArea],1);
			}
		//проверка добавления/редактирование
		if ($this->id['0']=="request") {
            //ADD
			if ($this->id['1']=="add"){
				$this->buttonAdd('area');
				if (model_Help::gi()->getInputData ('inputArea','help')){
					$inputArea = model_Help::gi()->getInputData ('inputArea','help');
                    $out = model_Help::gi()->insert($inputArea);
					if ($out=="01") {
					    $this->mess('Запись успешно добавлена', 1);
						$this->createTableArea();
						}
					else {
					  $this->mess('Такой район уже существует');
                      $this->createTableArea();
                      }
				}
				else $this->mess('Ошибка ввода, попробуйте повторить ввод');
				}//end request ADD
            //EDIT
        	if ($this->id['1']=="edit") {
        	    $dataInputArea = model_Help::gi()->getInputData('inputArea','help');
                      if ($dataInputArea){
                          $uidInputArea = $this->id[2];
                          $out = model_Help::gi()->updateDB(['textName'=> $dataInputArea],['uid'=>$uidInputArea]);
                          if ($out=='01') {
                                $this->mess('Запись успешно обновлена',1);
                                $this->createTableArea();
                                }
                          else {
                                $this->mess('Такой район уже существует');
                                $this->createTableArea();
                                }
                          }
                      else $this->mess('Ошибка ввода, попробуйте повторить ввод');
        	    }//end request EDIT
            }//end request

  		//удаление
  		if ($this->id['0']=='del') {
  			if (model_Help::gi()->getId($this->id[1])) {
  				//запрос на удаление
  				if (model_Help::gi()->del($this->id[1])) $this->mess('Запись успешно удалена',1);
  				else $this->mess('Запрос отклонен');
  				$this->createTableArea();
  				}
  			else  $this->mess('Ошибка передачи параметров');
  			}
  		//редактирование
  		if ($this->id['0']=='edit') {
      		$data = model_Help::gi()->selectUid($this->id[1],['textName','uid']);
      		if ($data!="02" or $data!="03") {
      			$formEditArea = $this->view->show('help/area/formEditArea',['value' => $data['textName'],'urlAction' => URL.'help/area/request/edit/'.$data['uid']],1);
      			$this->content['header'] = $this->view->show('help/header',['headerName' => 'Районы', 'headerButton' => $formEditArea],1);
      			}
      	    }

		}
//---------------------------------------------END AREA---------------------------------------------//
//-----------------------------------------------STREET---------------------------------------------//
	private function createTableStreet () {
	    model_Help::gi()->DB['table'] = 'etagi_helpStreet';
		$status = model_Help::gi()->select(['textName','uid']);
		if ( $status=="02" ) $this->mess('Таблица улиц пуста');
		else {
			$data = $status['data'];
			if (is_array($data)) {
				for ($i=0;$i<count($data);$i++) {
					$dataStreet = ['streetName' => $data[$i]['textName'], 'urlEdit'=>URL.'help/street/edit/'.$data[$i]['uid'],'urlDel'=>URL.'help/street/del/'.$data[$i]['uid']];
					$lineStreet = $lineStreet.$this->view->show('help/street/formStreet',$dataStreet,1);
					}
				$this->content['table'] = $this->view->show('help/street/formListStreet',['formStreet'=>$lineStreet],1);
				}
			}
		}

	public function action_street() {
	    model_Help::gi()->DB['table'] = 'etagi_helpStreet';
		//до дефолту
		if (!$this->id['0']) {
            $this->buttonAdd('street');
			$this->createTableStreet();
			}
		//форма добавления района
		if ($this->id['0']=="add"){
			$formInput = $this->view->show('help/street/formInputStreet',['urlAction' => URL.'help/street/request/add'],1);
    		$this->content['header'] = $this->view->show('help/header',['headerName' => 'Улицы', 'headerButton' => $formInput],1);
			}
		//проверка добавления/редактирование
		if ($this->id['0']=="request") {
            //ADD
			if ($this->id['1']=="add"){
				$this->buttonAdd('street');
				if (model_Help::gi()->getInputData ('inputStreet','help')){
					$inputStreet = model_Help::gi()->getInputData ('inputStreet','help');
                    $out = model_Help::gi()->insert($inputStreet);
					if ($out=="01") {
					    $this->mess('Запись успешно добавлена', 1);
						$this->createTableStreet();
						}
					else {
					  $this->mess('Такая улица уже существует');
                      $this->createTableStreet();
                      }
				}
				else $this->mess('Ошибка ввода, попробуйте повторить ввод');
				}//end request ADD
            //EDIT
        	if ($this->id['1']=="edit") {
        	    $dataInputStreet = model_Help::gi()->getInputData('inputStreet','help');
                      if ($dataInputStreet){
                          $uidInputStreet = $this->id[2];
                          $out = model_Help::gi()->updateDB(['textName'=> $dataInputStreet],['uid'=>$uidInputStreet]);
                          if ($out=='01') {
                                $this->mess('Запись успешно обновлена',1);
                                $this->createTableStreet();
                                }
                          else {
                                $this->mess('Такая улица уже существует');
                                $this->createTableStreet();
                                }
                          }
                      else $this->mess('Ошибка ввода, попробуйте повторить ввод');
        	    }//end request EDIT
            }//end request

  		//удаление
  		if ($this->id['0']=='del') {
  			if (model_Help::gi()->getId($this->id[1])) {
  				//запрос на удаление
  				if (model_Help::gi()->del($this->id[1])) $this->mess('Запись успешно удалена',1);
  				else $this->mess('Запрос отклонен');
  				$this->createTableStreet();
  				}
  			else  $this->mess('Ошибка передачи параметров');
  			}
  		//редактирование
  		if ($this->id['0']=='edit') {
      		$data = model_Help::gi()->selectUid($this->id[1],['textName','uid']);
      		if ($data!="02" or $data!="03") {
      			$formEditStreet = $this->view->show('help/street/formEditStreet',['value' => $data['textName'],'urlAction' => URL.'help/street/request/edit/'.$data['uid']],1);
      			$this->content['header'] = $this->view->show('help/header',['headerName' => 'Улицы', 'headerButton' => $formEditStreet],1);
      			}
      	    }

		}
//-------------------------------------------END STREET---------------------------------------------//
//------------------------------------------------ SNM ---------------------------------------------//
  public function keySNM (){
        $kkey[1] = "Риелтор";
        $kkey[2] = "Продавец";
        //$kkey[3] = "Продавец+Риелтор";
        return $kkey;
        }

	private function createTableSNM () {
	    model_Help::gi()->DB['table'] = 'etagi_helpSNM';
		$status = model_Help::gi()->select(['key','textSurname','textName','textMname','uid']);
		if ( $status=="02" ) $this->mess('Таблица ФИО пуста');
		else {
			$data = $status['data'];
			if (is_array($data)) {
				for ($i=0;$i<count($data);$i++) {
					$dataSNM = [
                                'textSurname'   => $data[$i]['textSurname'],
                                'textName'      => $data[$i]['textName'],
                                'textMname'     => $data[$i]['textMname'],
                                'key'           => $this->keySNM()[$data[$i]['key']],
                                'urlEdit'=>URL.'help/snm/edit/'.$data[$i]['uid'],
                                'urlDel'=>URL.'help/snm/del/'.$data[$i]['uid']
                                ];
					$lineSNM = $lineSNM.$this->view->show('help/snm/formSNM',$dataSNM,1);
					}
				$this->content['table'] = $this->view->show('help/snm/formListSNM',['formSNM'=>$lineSNM],1);
				}
			}
		}

	public function action_snm() {
	    model_Help::gi()->DB['table'] = 'etagi_helpSNM';
		//до дефолту
		if (!$this->id['0']) {
            $this->buttonAdd('snm');
			$this->createTableSNM();
			}
		//форма добавления района
		if ($this->id['0']=="add"){

            //создаем select option
		    $select = $this->keySNM();
            for ($i=1;$i<=count($select);$i++){
                $formSelectKey = @$formSelectKey."<option value=\"".$i."\">".$select[$i]."</option>";
                }//end select option
			$formInput = $this->view->show('help/snm/formInputSNM',['urlAction' => URL.'help/snm/request/add','option' => $formSelectKey],1);
    		$this->content['header'] = $this->view->show('help/header',['headerName' => 'ФИО', 'headerButton' => $formInput],1);
			}

		//проверка добавления/редактирование
		if ($this->id['0']=="request") {
            //ADD
			if ($this->id['1']=="add"){
				$this->buttonAdd('snm');
				if (
                    model_Help::gi()->getInputData ('inputS','help') &&
                    model_Help::gi()->getInputData ('inputN','help') &&
                    model_Help::gi()->getInputData ('inputM','help') &&
                    model_Help::gi()->getInputData ('inputKey','help')
                    ){
					$inputS = model_Help::gi()->getInputData ('inputS','help');
					$inputN = model_Help::gi()->getInputData ('inputN','help');
					$inputM = model_Help::gi()->getInputData ('inputM','help');
					$inputKey = model_Help::gi()->getInputData ('inputKey','help');
                    $mass = ['s'=> $inputS, 'n' => $inputN, 'm' => $inputM, 'key' => $inputKey ];
                    $out = model_Help::gi()->insert2($mass);

					if ($out=="01") {
					    $this->mess('Запись успешно добавлена', 1);
						$this->createTableSNM();
						}
					else {
					  $this->mess('Такаое ФИО уже существует');
                      $this->createTableSNM();
                      }
				}
				else $this->mess('Ошибка ввода, попробуйте повторить ввод');
				}//end request ADD
            //EDIT
        	if ($this->id['1']=="edit") {
    			$S = model_Help::gi()->getInputData     ('inputS',  'help');
    			$N = model_Help::gi()->getInputData     ('inputN',  'help');
    			$M = model_Help::gi()->getInputData     ('inputM',  'help');
    			$Key = model_Help::gi()->getInputData   ('inputKey','help');

                if ($S && $N && $M){
                    $uid = $this->id[2];

                    $dataSNM = [
                      'textSurname'   => $S,
                      'textName'      => $N,
                      'textMname'     => $M,
                      'key'           => $Key
                      ];

                    $out = model_Help::gi()->updateDB($dataSNM,['uid'=>$uid]);

                    if ($out=='01') {
                          $this->mess('Запись успешно обновлена',1);
                          $this->createTableSNM();
                          }
                    else {
                          $this->mess('Такое ФИО уже существует');
                          $this->createTableSNM();
                          }
                    }
                else $this->mess('Ошибка ввода, попробуйте повторить ввод');
  	            }//end request EDIT
            }//end request

  		//удаление
  		if ($this->id['0']=='del') {
  			if (model_Help::gi()->getId($this->id[1])) {
  				//запрос на удаление
  				if (model_Help::gi()->del($this->id[1])) $this->mess('Запись успешно удалена',1);
  				else $this->mess('Запрос отклонен');
  				$this->createTableSNM();
  				}
  			else  $this->mess('Ошибка передачи параметров');
  			}
          		//редактирование
  		if ($this->id['0']=='edit') {
      		$data = model_Help::gi()->selectUid($this->id[1],['key','textSurname','textName','textMname','uid']);
      		if ($data!="02" or $data!="03") {

      		    //selected
                $select = $this->keySNM();
                for ($i=1;$i<=count($select);$i++) {
                    if ($i == $data['key']) $selected = 'selected';
                    else  $selected = '';
                    $kkey = $kkey. "<option ".$selected." value=\"".$i."\">".$select[$i]."</option>";
                    }
                //end selected

      			$formEdit = $this->view->show('help/snm/formEditSNM',['option'=> $kkey,'valueS'=>$data['textSurname'],'valueN'=>$data['textName'],'valueM'=>$data['textMname'], 'urlAction' => URL.'help/snm/request/edit/'.$data['uid']],1);
      			$this->content['header'] = $this->view->show('help/header',['headerName' => 'ФИО', 'headerButton' => $formEdit],1);
      			}
      	    }
		}
//-------------------------------------------- END SNM ---------------------------------------------//

	public function action_index() {
	    //нужно описать раздел, что в нем можно делать и т.п. (общий характер)
		}

}