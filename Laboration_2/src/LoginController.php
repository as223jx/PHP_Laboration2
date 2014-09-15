<?php

//Kontrollera hur interakionen mellan användaren och systemet fungerar
//Flödet i hur programmet fungerar
//Frågar modellen, berättar för vyn

require_once("src/LoginModel.php");
require_once("src/LoginView.php");

class LoginController {
	private $view;
	private $model;
	
	public function __construct(){
		$this->model = new LoginModel();
		$this->view = new LoginView($this->model);
	}
	
	public function doControll() {
		//if($this->view->userPressedLogin()){
		//	$this->model->loggedIn();
		//}
		
		return $this->view->showLoginForm();
	}
}