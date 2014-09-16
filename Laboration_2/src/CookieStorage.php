<?php

class CookieStorage {
	private static $cookieName = "Username";

	public function save($cookieName, $value) {
		setcookie(self::$cookieName, $value, -1);

		var_dump($_COOKIE);
	}

	public function load() {

		//$ret = isset($_COOKIE["CookieStorage"]) ? $_COOKIE["CookieStorage"] : "";
		if (isset($_COOKIE[self::$cookieName])){
			$ret = $_COOKIE[self::$cookieName];
		}
		
		else{
			$ret = "";
			setcookie(self::$cookieName, "", time() -1);
			return $ret;
		}
	}
}