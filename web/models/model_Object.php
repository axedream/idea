<?php
class model_Object extends Model {

  public $errorm;

  public function __construct () {
    parent::__construct();

    }

  //получаем данные из формы
  public function getFormInput($type) {
      if ($type=="cn") {
        $this->errorm=FALSE;
        //получаем данные из полей и проверяем их
        //Город
        if(model_Post::gi()->getIDV('selectCity','hesh'))   $select['City']   =   model_Post::gi()->getIDV('selectCity',  'hesh'); else $this->errorm='Неверно передан UID города';
        //Район
        if(model_Post::gi()->getIDV('selectArea','hesh'))   $select['Area']   =   model_Post::gi()->getIDV('selectArea',  'hesh'); else $this->errorm='Неверно передан UID района';
        //Улица
        if(model_Post::gi()->getIDV('selectStreet','hesh')) $select['Street'] =   model_Post::gi()->getIDV('selectStreet','hesh'); else $this->errorm='Неверно передан UID улицы';
        //Цена
        if(model_Post::gi()->getIDV('price','price'))       $select['Price']  =   model_Post::gi()->getIDV('price','price');       else $this->errorm='Неверно указана цена';
        //ФИО Риелтора
        if(model_Post::gi()->getIDV('selectSNM1','hesh'))   $select['SNM1']   =   model_Post::gi()->getIDV('selectSNM1','hesh');   else $this->errorm='Неверно передан UID риелтора';
        if(model_Post::gi()->getIDV('selectSNM2','hesh'))   $select['SNM2']   =   model_Post::gi()->getIDV('selectSNM2','hesh');   else $this->errorm='Неверно передан UID продавца';
        //номер дома
        if(model_Post::gi()->getIDV('nd','nd'))             $select['nd']     =   model_Post::gi()->getIDV('nd','nd');             else $this->errorm='Неверно указан номер дома';
        //жилая прощадь кв м
        if(model_Post::gi()->getIDV('ls','price'))          $select['ls']     =   model_Post::gi()->getIDV('ls','price');          else $this->errorm='Неверно указана жилая площадь';
        //этаж
        if(model_Post::gi()->getIDV('floor','floor'))       $select['floor']  =   model_Post::gi()->getIDV('floor','floor');       else $this->errorm='Неверно указан этаж';
        //этажность
        if(model_Post::gi()->getIDV('nfloor','floor'))      $select['nfloor'] =   model_Post::gi()->getIDV('nfloor','floor');     else $this->errorm='Неверно указана этажность';
        //тип помещения
        if(model_Post::gi()->getIDV('tch','tch'))            $select['tch']    =   model_Post::gi()->getIDV('tch','tch');         else $this->errorm='Неверно передана тип помещения';

        if (!$this->errorm)return $select;
        else return FALSE;
        }
      }

  public function setCN ($mass) {
    $data = [
                'typeObject'  =>  '1',
                'uidCity'     =>  $mass['City'],
                'uidArea'     =>  $mass['Area'],
                'uidStreet'   =>  $mass['Street'],
                'uidSNMAgent' =>  $mass['SNM1'],
                'uidSNMOwner' =>  $mass['SNM2'],
                'price'       =>  $mass['Price'],
                'typeChild'   =>  $mass['tch'],
                'numberHome'  =>  $mass['nd'],
                'livingSpace' =>  $mass['ls'],
                'floor'       =>  $mass['floor'],
                'numberFloors'=>  $mass['nfloor'],
            ];

    model_Db::gi()->table = 'etagi_object';
    return model_Db::gi()->insert ($data);
    }//end setCN

  public function updateCN($mass,$uid) {
    $data = [
                'typeObject'  =>  '1',
                'uidCity'     =>  $mass['City'],
                'uidArea'     =>  $mass['Area'],
                'uidStreet'   =>  $mass['Street'],
                'uidSNMAgent' =>  $mass['SNM1'],
                'uidSNMOwner' =>  $mass['SNM2'],
                'price'       =>  $mass['Price'],
                'typeChild'   =>  $mass['tch'],
                'numberHome'  =>  $mass['nd'],
                'livingSpace' =>  $mass['ls'],
                'floor'       =>  $mass['floor'],
                'numberFloors'=>  $mass['nfloor'],
            ];
    model_Db::gi()->table = 'etagi_object';
    return model_Db::gi()->updateDB ($data,['uid'=>$uid]);
    }

  public function getCNUid($uid) {
  model_Db::gi()->table = 'etagi_object';
  return model_Db::gi()->selectKey(['uid','uidCity','uidArea','uidStreet','uidSNMAgent','uidSNMOwner','price','typeChild','numberHome','livingSpace','floor','numberFloors'],'uid',$uid);
  }

  public function getDataCN() {
    model_Db::gi()->table = 'etagi_object';
    $query = "
    SELECT
      object.typeChild AS tch,
      object.id,
      object.uid,
      city.textName as city,
      aarea.textName AS `area` ,
      street.textName AS street,
      object.numberHome AS nd,
      CONCAT (object.floor ,'/',object.numberFloors) AS home,
      object.price
    FROM
      etagi_object object
    LEFT JOIN etagi_helpCity   city     ON object.uidCity   = city.uid
    LEFT JOIN etagi_helpArea   aarea    ON object.uidArea   = aarea.uid
    LEFT JOIN etagi_helpStreet street   ON object.uidStreet = street.uid
    WHERE object.typeObject='1';
    ";
    return MySQLDB::gi()->getDBData ($query);
    }//end getData

  public function delCN($uid) {
    model_Db::gi()->table = 'etagi_object';
    return model_DB::gi()->del($uid);
    }//end delCN

  public function getTCH() {
    $tch[10] = 'Офисное помещение';
    $tch[11] = 'Торговое помещение';
    $tch[12] = 'Складское помещение';
    return $tch;
    }
}
