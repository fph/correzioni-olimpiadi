<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General","AskInformation.php");
	SuperRequire_once("General", "TemplateCreation.php");
	
	$contestId=$_GET["contestId"]; 
	
	$v_contest=RequestById("Contests",$contestId)["name"];
	
	$v_contestants=ContestantsByContest($contestId);
	
	TemplatePage("ViewContestantsOfAContest","ClassicUser");
?>
