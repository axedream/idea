<?php

class Access extends Singleton {

  public $user;           //пользователь
  public $group;          //группа доступа

  public $AC;             //массив доступов контроллеров
  public $AA;             //массив доступов действий
  public $AI;             //массив доступов ИД

  public $mess;           //сообщения из конфига
  public $flag;           //массив флогов

  public $dataDB;         //массив данных из базыданных

  public function __construct() {
    $this->mess = App::gi()->config['message'];
    }//end construct



  public function start() {
    $this->user =   User::gi()->user;
    $this->group =  User::gi()->group;
    }//end start

  public function getUserDataDB() {
    DLL_DB::gi()->table   = 'IDEa_Access';
    DLL_DB::gi()->select  = 'where';
    DLL_DB::gi()->flag = '=';
    DLL_DB::gi()->area    = ['userLogin'=>$this->user];
    DLL_DB::gi()->mass    = [
      'id',
      'uid',
      'dateCreate',
      'dateUpgrade',
      'dateDelete',
      'userAction',
      'userIPCreater',
      'userIPUpgrade',
      'active',
      'userLogin',
      'UAC',
      'UAA',
      'UAI',
      'userEducation'
    ];
    DLL_DB::gi()->selectDB();
    $out = MySQLDB::gi()->getDBData(DLL_DB::gi()->request);

    if (is_array($out)) {
      $this->flag['error'] = FALSE;
      $this->dataDB = $out;
      }//end ok getdata
    else {
      $this->flagGE = TRUE;
      $this->messGE = $this->mess['user']['DB'];
      }//end error data
    }//end GET

}//end ACCESS