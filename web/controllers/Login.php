<?php
class Login extends Controller{
	function __construct() {
		parent::__construct();
	}

  //������� ������� �� �����������
  /*��������� �������
  public function action_Register() {
  User::gi()->userAdd = "admin";
  User::gi()->passwordAdd = "superZXC123vbn";
  if (User::gi()->setUserDataDB()) {

    }//end OK
  else {

    }//bad OK
  }
  */

  public function action_Login() {
    //�������� ������ �� ����� ������� POST � �������� ���������� � ������ User
    User::gi()->userName      = model_Post::gi()->getIDV('login',   ['user'=>'login']);
    User::gi()->userPassword  = model_Post::gi()->getIDV('password',['user'=>'password']);
    //������������ ������ ����� ������ User (������� ��������������)
    User::gi()->logIn();
    }//end Login
  public function action_Logout() {
    User::gi()->logOut();
  }
}