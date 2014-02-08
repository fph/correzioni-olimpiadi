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
	
	function VerifyCredentials($postUser, $postPsw){
		$user=escape_input($postUser);
		$psw=escape_input(passwordHash($postPsw));
		
		$db=new mysqli(dbServer, dbUser, dbPass);
		if ($db->connect_errno) die($db->connect_error);
		
		$db->select_db(dbName);
		$query="SELECT id FROM Users WHERE user=$user AND passHash=$psw";
		$result=$db->query($query) or die($db->error);
		
		if ($UserId=mysqli_fetch_array($result)['id']) StartSession($UserId);
		else {
			echo "Username o password errati.\n";
		}
	}
?>

