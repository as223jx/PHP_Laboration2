<?php

class LoginView {
	private $model;
	
	public function __construct(LoginModel $model){
		$this->model = $model;
	}
	
	public function showLoginForm(){
		$ret = "";
		if ($this->userPressedLogin()){
			$ret .= "<p>Du har loggat in!</p>";
		}
		else{
			$ret .= "
			<form>
			Username: <input type='text' name='username'><br>
			Password: <input type='password' name='password'><br>
			<input type='checkbox' name='remember' value='Remember'>Remember me
			</form>
			<a href='?login'>Logga in</a>";
		}
		return $ret;
	}
	
	public function userPressedLogin(){
		
		if (isset($_GET["login"]) && $this->model->loggedIn()){
			return true;
		}
		
		else{
			return false;
		}
	}
}
