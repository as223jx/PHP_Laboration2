<?php

require_once("CookieStorage.php");

//Visualisera data
//Behöver tillgång till datan som den ska visualisera från modellen

class LoginView {
	private $model;
	private $cookie;
	private $username;
	
	public function __construct(LoginModel $model){
		$this->model = $model;
		$this->cookie = new CookieStorage();

	}
	
	//Visar login-formuläret om ej redan inloggad
	public function showLoginForm(){
			
		$username = $this->model->getLoggedInUser();
		echo $username;
		$ret = "";
		
		$date = date('Y-m-d H:i:s');
		
		echo $date;
		
		$ret = "
		<h1>Laborationskod as223jx</h1>
		<h2>Ej inloggad</h2>
		<form action='' method='post'>
		Användarnamn: <input type='text' name='username' id='username'>
		Lösenord: <input type='password' name='password'>
		<input type='checkbox' name='remember' value='Remember'>Håll mig inloggad: 
		<input type='submit' name='submit' value='Logga in'>
		</form>";

		if($this->userPressedLogin()){

			
			if ($this->model->login($_POST["username"], $_POST["password"])){
				
				$ret = $this->showLoggedIn($_POST["username"]);
			}
		}
		
		return $ret;
	}	
	
	//Inloggad
	public function showLoggedIn($username){
		$ret = "<h1>Laborationskod as223jx</h1><h2>".$username." är inloggad</h2><br><a href='?loggedOut'>Logga ut</a>";
		return $ret;
	}

	public function userPressedLogin(){
		
		if (isset($_POST["username"])){
			
            setcookie('Username', $_POST["username"], time()+60*60*24*365);
            setcookie('Password', crypt($_POST["password"]), time()+60*60*24*365);
			return true;
		}
		
		else{
			$this->cookie->load();
			return false;
		}
	}
}
