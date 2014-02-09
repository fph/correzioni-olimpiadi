<?php
	include_once "dbCredentials.php";
	function StartSession($UserId){
		echo $UserId;
		session_start();
		$_SESSION["UserId"]=$UserId;
		$_SESSION["LoginTimestamp"]=time();
		header("Location: index.php");
	}
	
	function EndSession(){
		session_start();
		session_unset();
		session_destroy();
	}
?>

