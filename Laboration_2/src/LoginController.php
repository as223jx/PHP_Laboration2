<?php

require_once("/src/LoginModel.php");
require_once("/src/LoginView.php");

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

        if($this->model->loggedInStatus()){
        	return $this->view->showLoggedIn($username);
        }
        else{
    		if($this->view->checkCookies()){
    			$this->model->setLoggedInStatus();
    			echo $this->view->loginSuccess();
    			return $this->view->showLoggedIn($username);
    		}
    		else{
    			if($this->view->userPressedLogin()){
    			    $this->model->setLoggedInStatus();
    			    $username = $this->view->getLoggedInUser();
    			    echo $this->view->loginSuccess();
    			 //$this->view->storeCookies();
    				return $this->view->showLoggedIn($username);
    			}
    			else{
    				return $this->view->showLoginForm();
    			}
    		}
        }

		//Om användaren redan är inloggad
//		if($this->model->loggedInStatus()){			
//                if($this->view->checkCookies()){
//				    return $this->view->showLoggedIn($username);
//                }
//                else{
//                    return $this->view->showLoggedIn($username);
//                }
//
//		}
		//Om användaren ej är inloggad
//		
//		else{
//			if($this->view->checkCookies()){
//					$this->model->setLoggedInStatus();
//					return $this->view->showLoggedIn($username);
//			}
//			else{
//				return $this->view->showLoginForm();
//			}
//		}
	}
}