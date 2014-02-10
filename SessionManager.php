<?php
	require_once "Utilities.php";
	
	function StartSession($UserId, $username){
		session_start();
		$_SESSION["UserId"]=$UserId;
		$_SESSION['username']=$username;
		$_SESSION["LoginTimestamp"]=time();
	}
	
	function EndSession(){
		session_start();
		session_unset();
		session_destroy();
	}
	
	function CheckSession() {
		session_start();
		if ( !isset($_SESSION["UserId"]) ) return 1;
		if ( time()-$_SESSION["LoginTimestamp"]>3600 ) return -1;
		return 0;
	}
?>

