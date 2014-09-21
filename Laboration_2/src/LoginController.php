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
		$username = $this->view->getLoggedInUser();
		echo $username;

		//Om användaren redan är inloggad
		//Session = 1
		if($this->model->loggedInStatus()){			
//                if($this->view->checkCookies()){
				    return $this->view->showLoggedIn($username);
//                }
//                else{
//                    return $this->view->showLoginForm();
//                }

		}
		//Om användaren ej är inloggad
		//Session = 0
		else{
			//Om cookies satta och cookiesen stämmer..
			if($this->view->checkCookies()){
				//Ger session = 1
					$this->model->setLoggedInStatus();
					//Visar inloggad
					return $this->view->showLoggedIn($username);
			}
			else{
				return $this->view->showLoginForm();
			}
		}
	
	}
}