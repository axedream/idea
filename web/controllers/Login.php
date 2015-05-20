<?php
class Login extends Controller{
	function __construct() {
		parent::__construct();
	}

	//проверка регистрационных данных
	function action_Login() {
		$data['login']		=	$_POST['login'];
		$data['password']	=	$_POST['password'];
		$this->view->show('login/formLogin',$data);
	}
}