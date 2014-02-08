<?php
	include_once "dbCredentials.php";
	
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
	
?>
