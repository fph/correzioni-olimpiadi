<?php

include_once "dbCredentials.php";
include_once "SessionManager.php";

session_start();
if (!isset($_SESSION["UserId"]) or time()-$_SESSION["LoginTimestamp"]>3600) EndSession();
else header("Location: index.php");

if (!is_null($_POST["user"])) VerifyCredentials($_POST["user"],$_POST["psw"]);

//~ session_start();
//~ if (!isset($_SESSION["UserId"]) or time()-$_SESSION["LoginTimestamp"]>3600) {
	//~ session_unset();
	//~ session_destroy();
//~ }
//~ else {
	//~ header("Location: index.php");
//~ }
//~ 
//~ if (!is_null($_POST["user"])) {
	//~ $user=escape_input($_POST["user"]);
	//~ $psw=escape_input(passwordHash($_POST["psw"]));
	//~ $db=new mysqli($dbServer, $dbUser, $dbPass);
	//~ if ($db->connect_errno) die($db->connect_error);
	//~ 
	//~ $db->select_db($dbName);
//~ 
	//~ $query="SELECT id FROM Users WHERE user=$user AND passHash=$psw";
	//~ $result=$db->query($query) or die($db->error);
	//~ 
	//~ if ($UserId=mysqli_fetch_array($result)['id']){
		//~ session_start();
		//~ $_SESSION["UserId"]=$UserId;
		//~ $_SESSION["LoginTimestamp"]=time();
		//~ header("Location: index.php");
	//~ }
	//~ else {
		//~ echo "Username o password errati.\n";
	//~ }
//~ }
	include "View/Login.php";
?>
