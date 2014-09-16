<?php

//Är användaren inloggad?
//Får användaren logga in?
//Vem är inloggad?

require_once("src/users.txt");

class LoginModel {
	private $loggedIn = "loggedIn";
	
	public function __construct(){
		
	}
	
	public function checkIfEmpty($username, $password){

		if(strlen($username) == 0 or strlen($password) == 0){
			
			if (strlen($username) == 0){
				echo "Användarnamn saknas";
			}
			else if (strlen($password) == 0){
				echo "Lösenord saknas";
			}
			return true;
		}
		
		return false;
	}
	
	//Kollar om användaren redan är inloggad eller ej
	public function loggedInStatus(){
			
		if(isset($_SESSION[$this->loggedIn]) == false){
			$_SESSION[$this->loggedIn] = 0;
		}
		
		if(isset($_GET["loggedOut"]) and $_SESSION[$this->loggedIn] == 1){
			$_SESSION[$this->loggedIn] = 0;
			session_destroy();
			echo "Du har nu loggat ut";
		}

		if($_SESSION[$this->loggedIn] == 0){
			return false;
		}
		else{
			return true;
		}
	}
	
	public function getLoggedInUser(){
		$username = "";
		
		if(isset($_SESSION["username"])){
			$username = $_SESSION["username"];
		}
		
		return $username;
	}
	
	public function login($username, $password){
		
		if($this->checkIfEmpty($username, $password) == false){
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
				if($username === $linesArr[$i] and $password === $linesArr[$i+1]){
					$_SESSION[$this->loggedIn] = 1;
					return true;
				}
				else{
					echo "Fel användarnamn eller lösenord";
					return false;
				}
				$i++;
			}
			
		}
	}
}