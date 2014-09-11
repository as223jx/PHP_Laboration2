<?php

class LoginView {
	private $model;
	
	public function __construct(LoginModel $model){
		$this->model = $model;
	}
	
	public function showLoginForm(){
		$ret ="";
		
		$ret .= "<a href='?login'>Logga in</a>";
		return $ret;
	}
	
	public function userPressedLogin(){
		if (isset($_GET["login"])){
			return true;
		}
		else{
			return false;
		}
	}
}
