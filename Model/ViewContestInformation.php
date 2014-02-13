<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General","AskInformation.php");
	SuperRequire_once("General", "TemplateCreation.php");
	
	$contestId=$_GET['contestId'];
	
	$db=OpenDbConnection();
	$v_contest=OneResultQuery($db, QuerySelect('Contests',['id'=>$contestId]));
	$db->close();
	
	TemplatePage("ViewContestInformation",[	'Index'=>'index.php',
											'Gare'=>'ViewContests.php',
											$v_contest['name']=>'ViewContestInformation.php?contestId='.$contestId]);
?>

