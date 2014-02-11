<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General","AskInformation.php");
	SuperRequire_once("General", "TemplateCreation.php");
	
	$problemId=$_GET["problemId"]; 
	
	$v_problem=RequestById($problemId);
	$v_corrections=AskProblem($problemId);
	
	TemplatePage("ViewProblem.php","ClassicUser");
?>
