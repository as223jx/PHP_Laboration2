<?php

require_once("src/LoginModel.php");
require_once("src/LoginView.php");

class LoginController {
	private $view;
	private $model;
	private $username = "";
	private $password = "";
	private $value;
	
	public function __construct(){
		$this->model = new LoginModel();
		$this->view = new LoginView($this->model);
	}
	
	public function doControll(){
			
		// Om användaren vill logga ut
		if($this->view->userPressedLogOut()){
			$this->view->logOut();
            $this->model->destroySession();
			return $this->view->showLoginForm();
		}
		
		// Om användaren är inloggad redan		
		if($this->model->userLoggedInStatus()){
			$this->username = $this->model->getLoggedInUser();
			return $this->view->showLoggedIn($this->username);
        }
		
		// Kollar om kakor finns
        if($this->view->checkIfCookiesExist()){
            // Testar logga in med kakorna
            if($this->model->login($this->view->getUsernameCookie(), $this->view->getPasswordCookie()) && !$this->view->checkIfCookieExpired()){
                $this->username = $this->model->getLoggedInUser();
                $this->view->cookieLoginMsg();
                return $this->view->showLoggedIn($this->username);
            }
            // Om det är fel information i kakorna tas dom bort och ett meddelande visas
            else{
                $this->view->logOut();
                $this->model->destroySession();
                $this->view->failedCookieLoginMsg();
            }
		}

		// Om användaren vill logga in
		if($this->view->userPressedLogin()){
			
			// Hämtar inputvärdena från formuläret	
			$this->username = $this->view->getUsername();
			$this->password = $this->view->getPassword();
			
			// Kollar på användarnamn och lösenord är ifyllt
			if($this->view->checkIfNotEmpty($this->username, $this->password)){
				
				// Försöker logga in med de angivna värdena
				if($this->model->login($this->username, $this->password)){
					// Meddelande om att inloggningen lyckades
					$this->view->loginSuccess();
					// Sätter cookies om användaren valt att bli ihågkommen
					if($this->view->rememberMe()){
						$this->view->setCookie();
					}
					//$this->view->storeCookies();
					return $this->view->showLoggedIn($this->username);
				}	
				
				// Om uppgifterna var fel visas login-forumläret igen
				else{
					$this->view->errorMsg();
					return $this->view->showLoginForm();
				}			
			}
		
		}
		
		// Visar annars login-formuläret som default
		return $this->view->showLoginForm();
	}
}