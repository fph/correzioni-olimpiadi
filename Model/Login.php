<?php
require_once "../Utilities.php";

SuperRequire_once("General", "SessionManager.php");
SuperRequire_once("General", "AskInformation.php");
SuperRequire_once("General", "TemplateCreation.php");

$SessionStatus=CheckSession();

if (!is_null($_POST["user"])) {
	$UserId=VerifyCredentials($_POST["user"],$_POST["psw"]);
	
	if( $UserId == -1 ) {
		TemplatePage("Login.php","");
	}
	else {
		StartSession($UserId,$_POST['user']);
		SuperRedirect("Model","index.php");
		die();
	}
}
else TemplatePage("Login.php","");
?>
