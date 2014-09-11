<?php

class HTMLView {
	
	public function echoHTML($body){
		if ($body == NULL) {
			throw new \Exception("Body can't be null");
		}
		
		echo "
			<!DOCTYPE html>
			<html>
			<body>
				$body
			</body>
			</html>
		";
	}
}
