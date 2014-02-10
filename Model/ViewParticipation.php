<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General","AskInformation.php");
	SuperRequire_once("General", "TemplateCreation.php");
	
	//~ $participationId=$_POST["participationId"];  //Riga commentata per il test
	$participationId=1;
	
	$contestId=ContestByParticipation($participationId);
	$contestantId=ContestantByParticipation($participationId);
	
	$v_contest_name=RequestById('Contests',$contestId)["name"];
	$v_contestant=RequestById('Contestants',$contestId);
	$v_corrections=AskParticipation($contestId,$contestantId);
	
	//~ foreach ($v_corrections as $cor) {
		//~ echo $cor["Problem"]." ";
		//~ if ($cor["done"]) echo $cor["User"];
		//~ echo "<br>";
	//~ }
	
	TemplatePage("ViewParticipation.php","ClassicUser");
?>
