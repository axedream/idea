<?php
class Objects extends Controller {
	
	public $conf;		//файл конфигурации меню
	public $ac;			//действие пользователя без префикса
	public $content;		//формирует содержимое странички
	public $id;			//динамические ID
  public $error;

	public function __construct () {
		parent::__construct();
		$this->ac = App::gi()->ac;
		$this->id = Router::gi()->id;
		$this->conf['menu'] = include VIEW.'objects/conf.php';
		if ($this->ac!='index') $this->conf['menu'][App::gi()->ac]['active'] = true;
		$this->createMenu();
        $this->buttonAdd();
		}

	public function __destruct () {
		$this->view->show('objects/body',$this->content);
		}

    public function mess($text,$type=FALSE) {
        if ($type)   $this->content['message'] = $this->view->show('objects/success',['text' => $text],1);
        else $this->content['message'] = $this->view->show('objects/error',  ['text' => $text],1);
        }

    public function buttonAdd($type=FALSE,$var=FALSE) {
      if (!$type) $type = $this->ac;
        if ($type=="flat") {
            $buttonAdd = $this->view->show('objects/buttonAdd',['helpULRAdd' => URL.'objects/flat/add'],1);
			      $this->content['header'] = $this->view->show('objects/header',['headerName' => 'Квартиры', 'headerButton' => $buttonAdd],1);
            }
        if ($type=="zn") {
            $buttonAdd = $this->view->show('objects/buttonAdd',['helpULRAdd' => URL.'objects/zn/add'],1);
      			$this->content['header'] = $this->view->show('objects/header',['headerName' => 'Загородная недвижимость', 'headerButton' => $buttonAdd],1);
            }
        if ($type=="cn") {
            $buttonAdd = $this->view->show('objects/buttonAdd',['helpULRAdd' => URL.'objects/cn/add'],1);
			      $this->content['header'] = $this->view->show('help/header',['headerName' => 'Коммерческая недвижимость', 'headerButton' => $buttonAdd],1);
            }
        if ($type=="free") {
			      $this->content['header'] = $this->view->show('help/header',['headerName' => 'Коммерческая недвижимость', 'headerButton' => ''],1);
          }
        }

	public function createMenu () {
		foreach ($this->conf['menu'] as $k => $v)
			{
			$data['url'] = URL.$v['url'];
			$data['active'] = ($v['active']) ? 'active' : '';
			$data['text'] = $v['text'];
			$cont = $cont.$this->view->show('objects/buttonLeft',$data,1);
			}
		$this->content['button'] = $cont;
		$this->view->show('objects/menu',$this->content);
		}

  //получаем 3 оснонвых варианта
  private function getDataBase ($name='') {
    model_DB::gi()->table = 'etagi_help'.$name;
    $data = model_DB::gi()->select(['uid','textName']);
    if ( is_array($data) ) { for ($i=0;$i<$data['count'];$i++) { $v = $data['data'][$i]['uid']; $k = $data['data'][$i]['textName']; $mass[$v] = $k; } }
    else return FALSE;
    return $mass;
    }

  //ФИО
  private function getDataSNM ($keys) {
    model_DB::gi()->table = 'etagi_helpSNM';
    model_DB::gi()->trable= 1;
    $data = model_DB::gi()->selectKey(['uid','CONCAT (textSurname," ",textName," ",textMname) as textName'],'key',$keys);
    model_DB::gi()->trable= 0;
    if ( is_array($data) ) { for ($i=0;$i<$data['count'];$i++) { $v = $data['data'][$i]['uid']; $k = $data['data'][$i]['textName']; $mass[$v] = $k; } }
    else return FALSE;
    return $mass;

    }

  public function listCN() {
  //$this->content['table'] = $this->view->show('objects/cn/table','',1);
  //echo $this->view->show('objects/cn/table','',1);
  $data = model_Object::gi()->getDataCN();
  if (is_array($data)) {
    $data = $data['data'];
    $tch = model_Object::gi()->getTCH();
    for ( $i=0;$i<count($data);$i++ )

      $body = $body. $this->view->show('objects/cn/area',
        [
        'city'  =>  $data[$i]['city'],
        'area'  =>  $data[$i]['area'],
        'street'=>  $data[$i]['street'],
        'nd'    =>  $data[$i]['nd'],
        'floor' =>  $data[$i]['home'],
        'price' =>  $data[$i]['price'],
        'tch'   =>  $tch[$data[$i]['tch']],
        'del'   =>  URL.'objects/cn/request/del/'.$data[$i]['uid'],
        'edit'  =>  URL.'objects/cn/request/edit/'.$data[$i]['uid']
        ],1);



    $this->content['table'] =  $this->view->show('objects/cn/table',['body'=>$body],1);
    }
  else $this->mess('Таблица недвижимости пуста');
  }


  //форма ффода объекта $type - тип объекта
  private function createFormInput($type,$edit=FALSE,$test=FALSE) {
    if ($type == 'cn') {
      //echo "<pre>";
      //var_dump($edit);
      //----------------------select TCH------------------//
      $tch = model_Object::gi()->getTCH();
      for ($i=10;$i<count($tch)+10;$i++) {
        if (is_array($edit)) $ss = ($edit['typeChild'] == $i) ? 'selected': '';
        $option = $option.$this->view->show('objects/form/option',['text'=>$tch[$i],'value'=>$i,'selected' => $ss ],1);
        }
      $select1 = $this->view->show ('objects/form/select',['name'=>'tch','option'=>$option],1); unset($option);

      $label = $this->view->show('objects/form/label',['name'=>'tch','text'=>'Выбирети тип объека'],1);
      $select['tch'] = $this->view->show('objects/form/formAdd',['label'=>$label,'body'=>$select1],1); unset($select1);
      //-----------------end--select TCH------------------//

      //----------------------selectCity------------------//
      $ss='';
      $mass=$this->getDataBase('City');
      if (is_array($mass)) foreach ($mass as $v => $k) {
        if(is_array($edit)) $ss = ($edit['uidCity'] == $v ) ? 'selected' : '';
        $option = $option.$this->view->show('objects/form/option',['text'=>$k,'value'=>$v,'selected' => $ss ],1);
        }
      $select1 = $this->view->show ('objects/form/select',['name'=>'selectCity','option'=>$option],1); unset($option);
      $label = $this->view->show('objects/form/label',['name'=>'selectCity','text'=>'Выбирети город'],1);
      $select['City'] = $this->view->show('objects/form/formAdd',['label'=>$label,'body'=>$select1],1); unset($select1);
      //-------------------end selectCity-----------------//

      //----------------------selectArea------------------//
      $ss='';
      $mass=$this->getDataBase('Area');
      if (is_array($mass)) foreach ($mass as $v => $k) {
        if (is_array($edit)) $ss = ($edit['uidArea'] == $v) ? 'selected' : '';
        $option = $option.$this->view->show('objects/form/option',['text'=>$k,'value'=>$v,'selected' => $ss ],1);
        }
      $select1 = $this->view->show ('objects/form/select',['name'=>'selectArea','option'=>$option],1); unset($option);
      $label = $this->view->show('objects/form/label',['name'=>'selectArea','text'=>'Выбирети район'],1);
      $select['Area'] = $this->view->show('objects/form/formAdd',['label'=>$label,'body'=>$select1],1);unset($select1);

      //-----------------end--selectArea------------------//

      //----------------------selectStreet------------------//
      $ss='';
      $mass=$this->getDataBase('Street');
      if (is_array($mass)) foreach ($mass as $v => $k) {
        if (is_array($edit)) $ss = ($edit['uidStreet']== $v) ? 'selected' : '';
        $option = $option.$this->view->show('objects/form/option',['text'=>$k,'value'=>$v,'selected' => $ss],1);
        }
      $select1 = $this->view->show ('objects/form/select',['name'=>'selectStreet','option'=>$option],1); unset($option);
      $label = $this->view->show('objects/form/label',['name'=>'selectStreet','text'=>'Выбирети улицу'],1);
      $select['Street'] = $this->view->show('objects/form/formAdd',['label'=>$label,'body'=>$select1],1);unset($select1);

      //-----------------end--selectStreet------------------//


      //----------------------selectSNM------------------//
      $ss='';
      for ($i=1;$i<=2;$i++) {   //проблема в том что мы не можем напрямую обратиться к данному параметру -- нужно выносить его в модель (моя ошибка признаю но нет времени поэтому КОСТЫЛИ!!!!!РРРРрррр)
        $mass=$this->getDataSNM($i);
        if (is_array($mass)) foreach ($mass as $v => $k) {
          if ( is_array($edit) ) {
            if ($i==1) $ss = ($edit['uidSNMAgent'] == $v) ? 'selected' : '';
            if ($i==2) $ss = ($edit['uidSNMOwner'] == $v) ? 'selected' : '';
            }
          $option = $option.$this->view->show('objects/form/option',['text'=>$k,'value'=>$v,'selected' => $ss],1); $ss='';
          }
        $select['SNM'.$i] = $this->view->show ('objects/form/select',['name'=>'selectSNM'.$i,'option'=>$option],1); unset($option);
        }
        $label1 = $this->view->show('objects/form/label',['name'=>'snm1','text'=>'Выберете ФИО риелтора'],1);
        $select['SNM1'] = $this->view->show('objects/form/formAdd',['label'=>$label1,'body'=>$select['SNM1']],1);
        $label2 = $this->view->show('objects/form/label',['name'=>'snm2','text'=>'Выберите ФИО продавца'],1);
        $select['SNM2'] = $this->view->show('objects/form/formAdd',['label'=>$label2,'body'=>$select['SNM2']],1);
        //snm1 - риэлетор; snm2 - продавец;
      //-----------------end--selectSNM------------------//

      //--------------------price-----------------------//
      $vv = (is_array($edit)) ? $edit['price']: '';
      if ($test) $input = $this->view->show('objects/form/input',['id'=>'price','name'=>'price','ph'=>'10.99','value'=>'10.99','type'=>'text'],1);
      else $input = $this->view->show('objects/form/input',['id'=>'price','name'=>'price','ph'=>'10.99','type'=>'text','value'=> $vv],1);

      $label = $this->view->show('objects/form/label',['name'=>'price','text'=>'Укажите цену объекта'],1);
      $form['price'] = $this->view->show('objects/form/formAdd',['label'=>$label,'body'=>$input],1); unset($input); unset($label);
      //---------------end--price-----------------------//

      //---------------------NUMBER of HOME-------------//
      $vv = (is_array($edit)) ? $edit['numberHome']: '';
      if ($test) $input = $this->view->show('objects/form/input',['id'=>'nd','name'=>'nd','ph'=>'10/2','value'=>'10/2','type'=>'text'],1);
      else $input = $this->view->show('objects/form/input',['id'=>'nd','name'=>'nd','ph'=>'10/2','type'=>'text','value'=>$vv],1);
      $label = $this->view->show('objects/form/label',['name'=>'nd','text'=>'Укажите номер дома'],1);
      $form['nd'] = $this->view->show('objects/form/formAdd',['label'=>$label,'body'=>$input],1); unset($input); unset($label);
      //----------------end--NUMBER of HOME-------------//

      //---------------------  livingSpace -------------//
      $vv = (is_array($edit)) ? $edit['livingSpace']: '';
      if ($test) $input = $this->view->show('objects/form/input',['id'=>'ls','name'=>'ls','ph'=>'100.1','value'=>'100.1','type'=>'text'],1);
      else $input = $this->view->show('objects/form/input',['id'=>'ls','name'=>'ls','ph'=>'100.1','type'=>'text','value'=>$vv],1);
      $label = $this->view->show('objects/form/label',['name'=>'ls','text'=>'Укажите жилую прощадь в м2'],1);
      $form['ls'] = $this->view->show('objects/form/formAdd',['label'=>$label,'body'=>$input],1); unset($input); unset($label);
      //----------------end-- livingSpace -------------//


      //---------------------  floor  -------------//
      $vv = (is_array($edit)) ? $edit['floor']: '';
      if ($test) $input = $this->view->show('objects/form/input',['id'=>'floor','name'=>'floor','ph'=>'1','value'=>'1','type'=>'text'],1);
      else $input = $this->view->show('objects/form/input',['id'=>'floor','name'=>'floor','ph'=>'1','type'=>'text','value'=>$vv],1);
      $label = $this->view->show('objects/form/label',['name'=>'floor','text'=>'Укажите этаж'],1);
      $form['floor'] = $this->view->show('objects/form/formAdd',['label'=>$label,'body'=>$input],1); unset($input); unset($label);
      //----------------end-- floor -------------//

      //--------------------- nfloor -------------//
      $vv = (is_array($edit)) ? $edit['numberFloors']: '';
      if ($test) $input = $this->view->show('objects/form/input',['id'=>'nfloor','name'=>'nfloor','ph'=>'12','value'=>'1','type'=>'text'],1);
      else $input = $this->view->show('objects/form/input',['id'=>'nfloor','name'=>'nfloor','ph'=>'12','type'=>'text','value'=>$vv],1);
      $label = $this->view->show('objects/form/label',['name'=>'nfloor','text'=>'Укажите этажность (количество этажей здания)'],1);
      $form['nfloor'] = $this->view->show('objects/form/formAdd',['label'=>$label,'body'=>$input],1); unset($input); unset($label);
      //----------------end-- nfloor -------------//

      //--------------------- button -------------//
      $input = (is_array($edit)) ? $this->view->show('objects/form/button',['text'=>'Редактировать'],1) : $this->view->show('objects/form/button',['text'=>'Добавить'],1);
      $form['button'] = $this->view->show('objects/form/formAdd',['label'=>'','body'=>$input],1); unset($input);
      //----------------end-- button -------------//


      //----------------------FINISH--------------------//
      $t = '<br><br>';
      $t = $t ."\n\r" . $select['tch'];
      $t = $t ."\n\r" . $select['City'] . $select['Area'] . $select['Street'];
      $t = $t ."\n\r" . $form['price'];
      $t = $t ."\n\r" . $select['SNM1'] . $select['SNM2'];
      $t = $t ."\n\r" . $form['nd'];
      $t = $t ."\n\r" . $form['ls'];
      $t = $t ."\n\r" . $form['floor'];
      $t = $t ."\n\r" . $form['nfloor'];
      $t = $t ."\n\r" . $form['button'];
      $t = $t . "<br><br>";
      $url = (is_array($edit)) ? URL.'objects/cn/edit/'.$edit['uid'] : URL.'objects/cn/request/add';
      $this->content['table'] = $this->view->show('objects/form/form',['body'=>$t,'urlAction'=>$url],1) ; unset($this->content['t']);
      unset ($select); unset($form);
      //-----------------end--FINISH--------------------//

      $this->buttonAdd("free"); //убираем кнопку "добавить"
      }
    }//end createFormInput

//--------------------------------------------------CN-------------------------------------------------//
  public function action_cn() {
		//form add flat
    if (!$this->id['0']) {
      $this->listCN();
      }
		if ($this->id['0']=="add"){
      //
      $this->createFormInput('cn');
			}

    if ($this->id['0'] == "edit") {
      $mass = model_Object::gi()->getFormInput('cn');
        if (!model_Object::gi()->errorm) {
          $data = model_Object::gi()->updateCN($mass,$this->id['1']);
          if ($data=="01") {
            $this->mess('Обект успешно изменен',1);
            $this->listCN();
            } //error SQL
          else $this->mess('Ошибка передачи запроса');

          }
        else $this->mess(model_Object::gi()->errorm);
      }

    if ($this->id['0']=="request") {

      if ($this->id['1']=="add") {
        $error = FALSE;
        $mass = model_Object::gi()->getFormInput('cn');
        if (!model_Object::gi()->errorm) {
          $data = model_Object::gi()->setCN($mass);
          if ($data=="01") {
            $this->mess('Обект успешно сохранен',1);
            $this->listCN();
            } //error SQL
          else $this->mess('Ошибка передачи запроса');
          }//end errorm post valid
        else $this->mess(model_Object::gi()->errorm);
        }//end ADD

      if ($this->id['1']=="del") {
        if (model_Object::gi()->delCN($this->id['2'])) {
            $this->mess('Объект успешно удален',1);
            $this->listCN();
          }//end request del
        else {
          $this->mess('Ошибка запроса');
          $this->listCN();
          }
        } //end DEL

      if ($this->id['1']=="edit") {
        $mass=model_Object::gi()->getCNUid($this->id['2']);
        if (is_array($mass)) {
          $this->createFormInput('cn',$mass['data'][0]);
          }
        else $this->mess('Ошибка запроса');
        }//end EDIT
      }//end REQUEST
    }
//----------------------------------------------END-CN-------------------------------------------------//

//-------------------------------------------------FLAT------------------------------------------------//
//public function action_flat() {}//end add flat
//---------------------------------------------END-FLAT------------------------------------------------//

//--------------------------------------------------ZN-------------------------------------------------//
//public function action_zn() {}
//----------------------------------------------END-ZN-------------------------------------------------//

  //нужно описать раздел, что в нем можно делать и т.п. (общий характер)
	public function action_index() {}

}