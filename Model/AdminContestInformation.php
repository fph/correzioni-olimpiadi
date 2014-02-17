<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	CheckPagePermission($db,-1);
	
	//PermissionChecked	

	$contestId=$_GET['contestId'];
	$v_contest=OneResultQuery($db, QuerySelect('Contests',['id'=>$contestId]));
	
	$db->close();

	echo 1;
	
	TemplatePage("AdminContestInformation",['Index'=>'index.php',
											'Amministrazione'=>'AdminAdministration.php',
											'Gare'=>'AdminContests.php',
											$v_contest['name']=>'AdminContestInformation.php?contestId='.$contestId]);
?>
