<?php

//Är användaren inloggad?
//Får användaren logga in?
//Vem är inloggad?

//require_once("/customers/c/4/b/alexandraseppanen.se//httpd.www/src/users.txt");

class LoginModel {
	private $loggedIn = "loggedIn";
	private $browser = "browser";
	private $username = "";
	
	public function __construct(){
		
	}
	
	// Returnerar true om användaren redan är inloggad
	public function userLoggedInStatus(){
	    // Kollar så ingen sessionsstöld har skett
        if(isset($_SESSION[$this->browser])){
            if ($_SESSION[$this->browser] != $_SERVER["HTTP_USER_AGENT"]){
                return false;
            }
		}
		
		if(isset($_SESSION[$this->loggedIn]) && $_SESSION[$this->loggedIn] == 1){
			return true;
		}
		else{
			return false;
		}
	}
	
	// Förstör sessionen
	public function destroySession(){
            session_unset();
            session_destroy();
	}
	
	//Hämtar användarnamnet på personen inloggad i sessionen
	public function getLoggedInUser(){
		if(isset($_SESSION["username"])){
			return $_SESSION["username"];
		}
	}
	
	// Loggar in
	public function login($username, $password){
		$_SESSION["username"] = $username;
		$_SESSION["password"] = $password;

		$linesArr = array();
		$fh = fopen("src/users.txt", "r");

		while (!feof($fh)){
			$line = fgets($fh);
			$line = trim($line);
			
			$linesArr[] = $line;
		}
		fclose($fh);

		for($i = 0; $i < count($linesArr); $i++){
			if($username === $linesArr[$i] && $password === $linesArr[$i+1] || md5($linesArr[$i+1])){
				$_SESSION[$this->loggedIn] = 1;
			    $_SESSION[$this->browser] = $_SERVER["HTTP_USER_AGENT"];
				return true;
			}

			else{
				return false;
			}
			$i++;
		}
	}
}