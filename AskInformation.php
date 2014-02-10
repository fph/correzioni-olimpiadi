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
	
	function AskParticipation($participation){
		
		$db=new mysqli(dbServer, dbUser, dbPass);
		if ($db->connect_errno) die($db->connect_error);
		
		//Dato l'id della partecipazione ottiene gli id di Contest e Contestant
		$db->select_db(dbName);
		$query="SELECT * FROM Participations WHERE id={$participation}";
		$result=$db->query($query) or die($db->error);
		
		$res=mysqli_fetch_array($result);
		$contest=escape_input($res["ContestId"]); //id del contest 
		$contestant=escape_input($res["ContestantId"]); //id del contestant
		
		//Mette nell'array problems le informazioni sui problemi della gara selezionata
		$query="SELECT * FROM Problems WHERE ContestId=$contest";
		$result=$db->query($query) or die($db->error);
		
		$problems=array();
		while ($row=mysqli_fetch_array($result)) array_push($problems,$row);
		
		$corrections=array();
		foreach ($problems as $prob) {
			$query="SELECT * FROM Corrections WHERE ContestantId={$contestant} AND ProblemId={$prob['id']}";
			$result=$db->query($query) or die($db->error);
			array_push($corrections, mysqli_fetch_array($result));
		}
		return $corrections;
	}
	
?>
