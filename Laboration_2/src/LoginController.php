<?php

require_once("src/LoginModel.php");
require_once("src/LoginView.php");

class LoginController {
	private $view;
	private $model;
	
	public function __construct(){
		$this->model = new LoginModel();
		$this->view = new LoginView($this->model);
	}
	
	public function doLogin() {
		if($this->view->userPressedLogin()){
			$this->model->login();
		}
		
		return "<p>Logga in!</p>";
	}
}