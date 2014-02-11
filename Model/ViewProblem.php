<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General","AskInformation.php");
	SuperRequire_once("General", "TemplateCreation.php");
	
	$problemId=$_GET["problemId"]; 
	$problem=RequestById("Problems",$problemId);
	
	$v_problem=$problem["name"];
	$v_contest=RequestById("Contests",$problem["ContestId"])["name"];
	$v_corrections=AskProblem($problemId);
	
	TemplatePage("ViewProblem","ClassicUser");
?>
