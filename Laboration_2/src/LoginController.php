<?php

//Kontrollera hur interakionen mellan användaren och systemet fungerar
//Flödet i hur programmet fungerar
//Frågar modellen, berättar för vyn

require_once("src/LoginModel.php");
require_once("src/LoginView.php");

class LoginController {
	private $view;
	private $model;
	private $username ="";
	
	public function __construct(){
		$this->model = new LoginModel();
		$this->view = new LoginView($this->model);
	}
	
	public function doControll() {
		
		$this->view->checkCookies();
		//Kollar om användaren är inloggad eller ej i sessionen
		if($this->model->loggedInStatus()){
			$username = $this->model->getLoggedInUser();
			return $this->view->showLoggedIn($username);
		}
		else{
			return $this->view->showLoginForm();
		}
		
	}
}