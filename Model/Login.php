<?php

include_once "dbCredentials.php";
include_once "SessionManager.php";
include_once "AskInformation.php";

session_start();

if (!isset($_SESSION["UserId"]) or time()-$_SESSION["LoginTimestamp"]>3600) EndSession();
else header("Location: index.php");

if (!is_null($_POST["user"])) {
	$UserId=VerifyCredentials($_POST["user"],$_POST["psw"]);
	if( $UserId == -1 ) {
		include "View/Login.php";
	}
	else include "View/GeneralTemplate.php?Content=index.php";
}
?>
