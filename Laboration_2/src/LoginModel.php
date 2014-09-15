<?php

//Är användaren inloggad?
//Får användaren logga in?
//Vem är inloggad?

class LoginModel {
	
	public function __construct(){
		
	}
	
	public function loggedIn($username, $password){
		
			if (strlen($username) > 0 && strlen($password) > 0){
				return true;
			}
			
			else{
				return false;
			}
	}
}