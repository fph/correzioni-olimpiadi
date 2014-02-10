<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General","AskInformation.php");
	SuperRequire_once("General", "TemplateCreation.php");
	
	$participationId=$_GET["participationId"]; 
	
	$contestId=ContestByParticipation($participationId);
	$contestantId=ContestantByParticipation($participationId);
	
	$v_contest_name=RequestById('Contests',$contestId)["name"];
	$v_contestant=RequestById('Contestants',$contestId);
	$v_corrections=AskParticipation($contestId,$contestantId);
	
	TemplatePage("ViewParticipation.php","ClassicUser");
?>
