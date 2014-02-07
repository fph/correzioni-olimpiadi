<?php
include "dbCredentials.php";
session_start();
if (!isset($_SESSION["UserId"]) or time()-$_SESSION["LoginTimestamp"]>3600) {
	session_unset();
	session_destroy();
}
else {
	header("index.php");
}

if (!is_null($_POST["user"])) {
	$user=escape_input($_POST["user"]);
	echo password_hash('acca',PASSWORD_DEFAULT);
	$psw=escape_input(password_hash($_POST["psw"],PASSWORD_DEFAULT));
	echo 1;
	$db=new mysqli($dbServer, $dbUser, $dbPass);
	if ($db->connect_errno) die($db->connect_error);
	
	$db->select_db($dbName);

	$query="SELECT 1 id FROM Users WHERE user=$user AND passHash=$psw";
	$result=$db->query($query) or die($db->error);

	if ($UserId=mysqli_fetch_array($result)['id']){
		session_start();
		$_SESSION["UserId"]=$UserId;
		$_SESSION["timestamp"]=time();
		header("index.php");
	}
	else {
		echo "Username o password errati.\n";
	}
}

?>

<form name=input" method="POST" action="Login.php">
	<input type="text" name="user" value="Username">
	<input type="text" name="psw" value="Password">
	<input type="submit" value="Login">
</form>
