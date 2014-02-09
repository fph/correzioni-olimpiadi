<?php

	include_once "../dbCredentials.php";
	
	//~ $participation=escape_input($_POST["ParticipationId"]);
	$participation=escape_input('1');
	
	
	$db=new mysqli(dbServer, dbUser, dbPass);
	if ($db->connect_errno) die($db->connect_error);
	
	//Dato l'id della partecipazione ottiene gli id di Contest e Contestant
	$db->select_db(dbName);
	$query="SELECT * FROM Participations WHERE id=$participation";
	$result=$db->query($query) or die($db->error);
	
	$res=mysqli_fetch_array($result);
	$contest=escape_input($res["ContestId"]); //id del contest 
	$contestant=escape_input($res["ContestantId"]); //id del contestant
	
	//Mette nell'array problems le informazioni sui problemi della gara selezionata
	$query="SELECT * FROM Problems WHERE ContestId=$contest";
	$result=$db->query($query) or die($db->error);
	
	$problems=array();
	while ($row=mysqli_fetch_array($result)) array_push($problems,$row);
	//~ foreach ($problems as $prob) echo $prob["id"]." ".$prob["name"]."<br>";
	
	$corrections=array();
	foreach ($problems as $prob) {
		$query="SELECT * FROM Corrections WHERE ContestantId=$contestant AND ProblemId=$prob['id']";
		$result=$db->query($query) or die($db->error);
		array_push($corrections, mysqli_fetch_array($prob));
	}
	
	foreach ($corrections as $cor) {
		echo $cor["ProblemId"]." ".$cor["mark"]."<br>";
	}
?>
