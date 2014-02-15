<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	$contestId=$_GET['contestId'];
	
	CheckPagePermission($db,$contestId);
	
	//PermissionChecked	
	
	$v_contest=OneResultQuery($db, QuerySelect('Contests',['id'=>$contestId]));
	
	$db->close();
	
	TemplatePage("ViewContestInformation",[	'Index'=>'index.php',
											'Gare'=>'ViewContests.php',
											$v_contest['name']=>'ViewContestInformation.php?contestId='.$contestId]);
?>

