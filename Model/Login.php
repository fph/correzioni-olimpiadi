<?php
require_once "../Utilities.php";

SuperRequire_once("General", "SessionManager.php");
SuperRequire_once("General", "AskInformation.php");
SuperRequire_once("General", "TemplateCreation.php");

$SessionStatus=CheckSession();

if( CheckSession() == -1 ) {
	TemplatePage("Login.php","SessionExpired");
	die();
}
else if( CheckSession() == 1 ) {
	SuperRedirect("Model","index.php");
	die();
}
else if ( CheckSession()==0 and !is_null($_POST["user"]) ) {
	$UserId=VerifyCredentials($_POST["user"],$_POST["psw"]);
	
	if( $UserId == -1 ) {
		TemplatePage("Login.php","LoginError");
	}
	else {
		StartSession($UserId,$_POST['user']);
		SuperRedirect("Model","index.php");
		die();
	}
}
else if( CheckSession()==0 ) TemplatePage("Login.php","");
?>
