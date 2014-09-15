<?php

//Är användaren inloggad?
//Får användaren logga in?
//Vem är inloggad?

require_once("src/users.txt");

class LoginModel {
	
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
	
	public function login($username, $password){
			
			if($this->checkIfEmpty($username, $password) == false){
				
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