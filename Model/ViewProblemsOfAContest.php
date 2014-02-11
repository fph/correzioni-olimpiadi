<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General","AskInformation.php");
	SuperRequire_once("General", "TemplateCreation.php");
	
	$v_contestId=$_GET["contestId"]; 
	
	$v_contest=RequestById("Contests",$v_contestId)["name"];
	
	$v_problems=ProblemsByContest($v_contestId);
	
	TemplatePage("ViewContestantsOfAContest","ClassicUser");
?>
