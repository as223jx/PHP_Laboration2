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
	
	//
	//
	// Fixa! Endast modellen talar med sessionen
	//
	//
	public function loggedInStatus(){
		if(isset($_SESSION["loggedIn"]) == false){
			$_SESSION["loggedIn"] = 0;
		}
		
		if($_SESSION["loggedIn"] == 0){
			return false;
		}
		else{
			return true;
		}
	}
	
	//Visar login-formuläret om ej redan inloggad
	public function showLoginForm(){
		$ret = "";

		if($_SESSION["loggedIn"] == 0){
		
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
					$_SESSION["loggedIn"] = 1;
					
					$ret .= "<p>You are logged in. Welcome, ". $_SESSION["username"]."!</p>";
				}
				//else{
				//	$ret .= "Wrong username or password!";
				//}
			}
		}

		return $ret;
	}	
	
	//Inloggad
	public function showLoggedIn(){
		$ret = "<p>You are logged in. Welcome, ". $_SESSION["username"]."</p>";
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
