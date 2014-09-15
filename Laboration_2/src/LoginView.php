<?php

//Visualisera data
//Behöver tillgång till datan som den ska visualisera från modellen

class LoginView {
	private $model;
	
	public function __construct(LoginModel $model){
		$this->model = $model;
	}
	
	public function showLoginForm(){
		$ret = "";
		$username = "inget";
		
		if($this->userPressedLogin()){
			$username = $_POST["username"];	
			$password = $_POST["password"];
			
			if ($this->model->loggedIn($username, $password)){
				$ret .= "<p>You are logged in. Welcome, $username ! Password: $password</p>";
			}
			else{
				$ret .= "Please fill in both fields!";
			}
		}
		
		else{
			$ret .= "
			<form action='' method='post'>
			Username: <input type='text' name='username' id='username'><br>
			Password: <input type='password' name='password'><br>
			<input type='checkbox' name='remember' value='Remember'>Remember me
			<input type='submit' name='submit' value='submit'>
			</form>";
			//<a href='?login'>Logga in</a>
			
		}
		
		return $ret;
	}
	
	public function userPressedLogin(){
		
		if (isset($_POST["username"])){
			echo "Ja";
			return true;
		}
		
		else{
			echo "Nej";
			return false;
		}
	}
}
