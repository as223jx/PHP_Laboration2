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

				if($this->rememberValue == true){
						$this->setCookie();
						echo "Kaka satt";
						echo $_COOKIE["Username"];
						echo $_COOKIE["Password"];
						}
						
				// if(isset($_COOKIE["Username"]) && (isset($_COOKIE["Password"]))){
					// echo "Här ska det skrivas";
					// $storage = fopen("src/storage.txt", "w");
					// $data = $_COOKIE["Username"] . "\n". $_COOKIE["Password"];
					// fwrite($storage, $data);
					// fclose($storage);

				//}
				$ret = $this->showLoggedIn($_POST["username"]);
			}
		}
		
		return $ret;
	}	
	
	public function setCookie(){
		echo "setCookie lalalalala";
		setcookie('Username', $_POST["username"], time()+60*60*24*365, "/");
		setcookie('Password', crypt($_POST["password"]), time()+60*60*24*365, "/");
		return;
	}
	
	public function getLoggedInUser(){
		$username = "";
		
		if(isset($_COOKIE["Username"])){
			$username = $_COOKIE["Username"];
		}
		else{
			$username = $this->model->getLoggedInUser();
		}
		
		return $username;
	}
	
	//Inloggad
	public function showLoggedIn($username){
		if(isset($_COOKIE["Username"])){
			$username = $_COOKIE["Username"];
			echo "Username: " . $username;
		}
		
		if(isset($_COOKIE["Password"])){
			echo $_COOKIE["Password"];
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
		if(isset($_COOKIE["Username"]) && (isset($_COOKIE["Password"]))){
			$password = "";
			$username = "";
			if ($_SESSION["loggedIn"] == 1){
				echo "Store cookies";
				$this->storeCookies();
			}
			echo "Sessionsvärde: " . $_SESSION["loggedIn"];
			
			$linesArr = array();
			$fh = fopen("src/storage.txt", "r");
			
			while (!feof($fh)){
				$line = fgets($fh);
				$line = trim($line);
				
				$linesArr[] = $line;
			}
			fclose($fh);
			
			if(count($linesArr) == 2){
			$username = $linesArr[0];
			$password = $linesArr[1];
			}
			else{ echo "Finns inget stored!";
				if(isset($_COOKIE["Password"])){
					echo "Kaka password : " . $_COOKIE["Password"];
				}
			}
			
			if($_COOKIE["Username"] == $username && $_COOKIE["Password"] == $password){
				echo "Inloggning lyckades via cookies";
				return true;
			}
			else {
				echo "Felaktig information i cookie";
				return false;
			}
		}
		
		else{
			return false;
		}
	}
	
	public function storeCookies(){
			$storage = fopen("src/storage.txt", "w");
			$data = $_COOKIE["Username"] . "\n". $_COOKIE["Password"];
			fwrite($storage, $data);
			fclose($storage);
			echo "Kakan skriven till fil";
			return;
	}
}
