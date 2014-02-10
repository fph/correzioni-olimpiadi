<?php
	require_once "Utilities.php";
	SuperRequire_once("General", "sqlUtilities.php");
	
	function AskCategory($category){
		global $TableInformation;
		$db=new mysqli(dbServer, dbUser, dbPass);
		if ($db->connect_errno) die($db->connect_error);
		
		$db->select_db(dbName);
		$query="SELECT * FROM $category";
		$result=$db->query($query) or die($db->error);
		
		while ($row=mysqli_fetch_array($result)) {
			foreach ($TableInformation[$category] as $v) echo $row[$v]." ";
			echo "<br>";
		}
	}
	
	function VerifyCredentials($postUser, $postPsw){
		$user=escape_input($postUser);
		$psw=escape_input(passwordHash($postPsw));
		
		$db=new mysqli(dbServer, dbUser, dbPass);
		if ($db->connect_errno) die($db->connect_error);
		
		$db->select_db(dbName);
		$query="SELECT id FROM Users WHERE user=$user AND passHash=$psw";
		$result=$db->query($query) or die($db->error);
		
		if ($UserId=mysqli_fetch_array($result)['id']) return $UserId;
		return -1;
	}
	
?>
