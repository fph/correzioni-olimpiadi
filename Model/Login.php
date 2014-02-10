<?php
require_once "../Utilities.php";

SuperRequire_once("General", "SessionManager.php");
SuperRequire_once("General", "AskInformation.php");
SuperRequire_once("General", "TemplateCreation.php");

session_start();

if (!isset($_SESSION["UserId"]) or time()-$_SESSION["LoginTimestamp"]>3600) EndSession();
else {
	SuperRedirect("Model","index.php");
	die();
}

if (!is_null($_POST["user"])) {
	$UserId=VerifyCredentials($_POST["user"],$_POST["psw"]);
	
	if( $UserId == -1 ) {
		TemplatePage("Login.php","");
	}
	else {
		StartSession($UserId);
		SuperRedirect("Model","index.php");
		die();
	}
}
else TemplatePage("Login.php","");
?>
