<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	CheckPagePermission($db,-1);
	
	//PermissionChecked	

	$ContestId=$_GET['ContestId'];
	$v_contest=OneResultQuery($db, QuerySelect('Contests',['id'=>$ContestId]));
	
	$db->close();

	echo 1;
	
	TemplatePage("AdminContestInformation",['Index'=>'index.php',
											'Amministrazione'=>'AdminAdministration.php',
											'Gare'=>'AdminContests.php',
											$v_contest['name']=>'AdminContestInformation.php?ContestId='.$ContestId]);
?>
