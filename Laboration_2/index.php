<?php

require_once ("/common/HTMLView.php");
require_once ("/src/LoginController.php");
require_once ("/src/LoginView.php");
require_once ("/src/LoginModel.php");

$c = new LoginController();
$htmlBody = $c->doLogin();

$view = new HTMLView();
$view->echoHTML($htmlBody);
