<?php

//Visualisera data
//Behöver tillgång till datan som den ska visualisera från modellen

class LoginView {
	private $model;
	private $username;
	private $password = "";
	
	public function __construct(LoginModel $model){
		$this->model = $model;
	}
	
	//Visar login-formuläret om ej redan inloggad
	public function showLoginForm(){
		$ret = "";
		
		$ret = "
		<h1>Laborationskod as223jx</h2>
		<h2>Ej inloggad</h2>
		<form action='' method='post'>
		Användarnamn: <input type='text' name='username' id='username'>
		Lösenord: <input type='password' name='password'>
		<input type='checkbox' name='remember' value='Remember'>Håll mig inloggad: 
		<input type='submit' name='submit' value='Logga in'>
		</form>";

		if($this->userPressedLogin()){
			$_SESSION["username"] = $_POST["username"];	
			$_SESSION["password"] = $_POST["password"];
			
			if ($this->model->login($_SESSION["username"], $_SESSION["password"])){
				
				$ret = $this->showLoggedIn();
			}
		}
		
		return $ret;
	}	
	
	//Inloggad
	public function showLoggedIn(){
		$ret = "<h2>".$_SESSION["username"]." är inloggad</h2><br><a href='?loggedOut'>Logga ut</a>";
		return $ret;
	}

	public function userPressedLogin(){
		
		if (isset($_POST["username"])){
			return true;
		}
		
		else{

			return false;
		}
	}
}
