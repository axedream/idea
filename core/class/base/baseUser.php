<?php

class User extends Singleton {

  public $rip;            //ip адресс удаленного пользователя
  public $user;           //имя пользователя
  public $group;          //имя группы

  public $userName;       //имя пользователя для авторизации (не подтвержденное)
  public $userPassword;   //пароль пользователя в md5 для авторизации (не подтвержденный)

  public $flagAut;        //флаг авторизации

  public $userAdd;        //имя добавляемого пользователя
  public $passwordAdd;    //пароль добавляемого пользователя
  public $groupAdd;       //группа добавляемого пользователя

  public $flagSS;         //флаг сесси;
  public $flagGE;         //флаг глобальной ошибки
  public $messGE;         //глобальное сообщение

  public $mess;           //сообщения из конфига

  public $dataDB;         //полученные данные по пользователю из базы данных

  public function __construct() {

    $this->mess = App::gi()->config['message'];
    }//end construct



  public function start() {

    if (!session_start()) {
      $this->messGE = $this->mess['user']['session'];
      $this->flagSS = TRUE;
      }
    else {
      //проверка сессионных данных
      if (!isset($_SESSION['group']) or  !isset($_SESSION['user']) or $_SESSION['user']=="guest" or $_SESSION['group']=="guest") $this->unsetSS();
      else $this->setSS();

      $this->rip = $_SERVER['REMOTE_ADDR'];
      $this->flagSS = FALSE;
      }//end session start
    }//end start


  //установка переменных сеии
  public function setSS() {
    $this->user   = $_SESSION['user'];
    $this->group  = $_SESSION['group'];
    $this->flagAut = TRUE;
    }//end setSS

  //сброс сессии
  public function unsetSS() {
    $_SESSION['group']	= "guest";
    $_SESSION['user'] 	= "guest";
    $this->user         = "guest";
    $this->group        = "guest";
    $this->flagAut = FALSE;
    }//end unsetSS

  //запись данных о пользователе в базу
  public function setUserDataDB() {
    DLL_DB::gi()->table = 'IDEa_Users';
    DLL_DB::gi()->getHelpData();
    $helpMass = DLL_DB::gi()->dataDB;

    //конвертируем необходимый нам массив
    DLL_DB::gi()->mass =
        [
        'id'=>$helpMass['id'],                    //уникальный ID (последний ID+1)
        'uid'=>$helpMass['uid'],                  //уникальных hesh
        'dateCreate'=>$helpMass['DA'],            //полная дата
        'userAction'=>'0',                        //по умолчанию пользователь не активный
        'userIPCreater'=>$helpMass['IP'],        //IP создателя записи
        'userLogin'=>$this->userAdd,              //логин пользователя
        'userPassword'=>md5($this->passwordAdd)   //пароль пользователя
        ];
    //echo $request = DLL_DB::gi()->insertIntoDB()."<br>";
    if (MySQLDB::gi()->setDBData(DLL_DB::gi()->insertIntoDB()) == "01"){
      $this->flagGE = FALSE;
      $this->messGE = $this->mess['user']['true'];
      }
    else {
      $this->flagGE = TRUE;
      $this->messGE = $this->mess['user']['duplicate'];
      }
    }

  //получение данных о пользователе из базы данных
  public function getUserDataDB() {

    DLL_DB::gi()->table   = 'IDEa_Users';
    DLL_DB::gi()->select  = 'where';
    DLL_DB::gi()->area    = ['userLogin'=>$this->userName];
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
      'userFIO',
      'userGroup',
      'userPassword',
      'userBDate',
      'userCity',
      'userMarital',
      'userEducation'
    ];
    DLL_DB::gi()->flag = '=';
    DLL_DB::gi()->selectDB();
    $out = MySQLDB::gi()->getDBData(DLL_DB::gi()->request);
    if (is_array($out)) {
      $this->flagGE = FALSE;
      $this->dataDB = $out;
      }//end ok getdata
    else {
      $this->flagGE = TRUE;
      $this->messGE = $this->mess['user']['DB'];
      }//end error data
    }//end getuserdata


  //выход из системы
  public function logOut() {
    $this->unsetSS();
    }//end logOut

  //авторизация пользователя
  public function logIn () {
    //проверяем текущее имя пользователя и пароль (авторизоваться без выхода НЕЛЬЗЯ!)
    if ($this->user=="guest" && $this->group=="guest") {
      $this->getUserDataDB();
      if (!$this->flagGE) {     //valid login
        if  ( md5($this->userPassword)==($this->dataDB['data']['0']['userPassword']) ) {
          //проверка на активность записи (по умолчанию записи деактивированы)
          if ($this->dataDB['data']['0']['active']) {
            $_SESSION['group']  = $this->dataDB['data']['0']['userGroup'];
            $_SESSION['user']   = $this->dataDB['data']['0']['userLogin'];
            $this->setSS();
            $this->messGE = $this->mess['user']['UserFine'];
            $this->flagGE = 'gooduser';
            }//end active (актуальность запись)
          else {
            $this->unsetSS();
            $this->messGE = $this->mess['user']['UserNot'];
            $this->flagGE = 'baduser';
            }
          }//end true autorize
        else {
          $this->unsetSS();
          $this->messGE = $this->mess['user']['UserNot'];
          $this->flagGE = 'baduser';
          }//end false autorize

        }//end valid from login
        else {
        $this->unsetSS();
        $this->messGE = $this->mess['user']['UserNot'];
        $this->flagGE = 'baduser';
        }//

      }//end user & group ok
    else {
      $this->messGE = $this->mess['user']['UserNot'];
      $this->flagGE = 'baduser';
      }
    }//end logIn








}