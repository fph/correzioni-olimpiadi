<?php
	require_once "Utilities.php";
	
	function StartSession($UserId){
		session_start();
		$_SESSION["UserId"]=$UserId;
		$_SESSION["LoginTimestamp"]=time();
	}
	
	function EndSession(){
		session_start();
		session_unset();
		session_destroy();
	}
?>

