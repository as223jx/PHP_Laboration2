<?php

//Visualisera data
//Behöver tillgång till datan som den ska visualisera från modellen

class LoginView {
	private $model;
	private $username;
	private $rememberValue;
	
	public function __construct(LoginModel $model){
		$this->model = $model;

	}
	
	//Visar login-formuläret om ej redan inloggad
	public function showLoginForm(){
			
		$username = $this->model->getLoggedInUser();
		//echo $username;
		$ret = "";
		
		setlocale(LC_TIME, "swedish");
		$dateTime = strftime('%A') . ", den " .strftime('%d'). " " .ucfirst(strftime("%B")). " år " .strftime("%Y"). ". Klockan är [" .strftime("%H:%M:%S"). "]";
		$dateTime = ucfirst($dateTime);
		$date = date('l'). " den " .date('jS F') ." år ". date('Y') . ". Klockan är [". date('h:i:s A') . "].";

		$ret = "
		<h1>Laborationskod as223jx</h1>
		<h2>Ej inloggad</h2>
		<form action='' method='post'>
		<fieldset>
		<legend>Login - Skriv in användarnamn och lösenord</legend>
		Användarnamn: <input type='text' name='username' id='username'>
		Lösenord: <input type='password' name='password'>
		<input type='checkbox' name='remember' value='Remember'>Håll mig inloggad: 
		<input type='submit' name='submit' value='Logga in'>
		</fieldset>
		</form>
		<p>$dateTime</p>";

		if($this->userPressedLogin()){
			if (isset($_POST["remember"])){
				$this->rememberValue = true;
			}
			else{
				$this->rememberValue = false;
			}
			if ($this->model->login($_POST["username"], $_POST["password"], $this->rememberValue)){
				
				$ret = $this->showLoggedIn($_POST["username"]);
			}
		}
		
		return $ret;
	}	
	
	//Inloggad
	public function showLoggedIn($username){
		if(isset($_COOKIE["username"])){
			$username = $_COOKIE["username"];
		}
		//<a href='?loggedOut'>Logga ut</a>
		$ret = "<h1>Laborationskod as223jx</h1><h2>".$username." är inloggad</h2><br>
		<form action='' method='post'>
		<input type='submit' value='Logga ut' name='logOut'/>
		</form>";
		return $ret;
	}

	public function userPressedLogin(){
		
		if (isset($_POST["username"])){
			//if(isset($_POST["remember"])){
			//	echo "Håll mig inloggad";
			//}
			return true;
		}
		
		else{
			return false;
		}
	}
	
	public function checkCookies(){
		if(isset($_COOKIE["Username"]) && ($_COOKIE["Password"])){
			$this->model->login($_COOKIE["Username"], $_COOKIE["Password"], true);
			return true;
		}
		else{
			return false;
		}
	}
}
