<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	CheckPagePermission($db,-1);
	
	//PermissionChecked
	
	$ContestId=$_GET['ContestId'];
	
	$v_contest=OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));

	$admins=ManyResultQuery($db, QuerySelect('Administrators'));
	$other_users=ManyResultQuery($db, QuerySelect('Permissions', ['ContestId'=>$ContestId]));
	$v_users=[];
	
	foreach($admins as &$adm){
		$nn=OneResultQuery($db, QuerySelect('Users', ['id'=>$adm['UserId']]));
		$nn['admin']=true;
		$v_users[]=$nn;
	}
	foreach($other_users as &$oth){
		$nn=OneResultQuery($db, QuerySelect('Users', ['id'=>$oth['UserId']]));
		$nn['admin']=false;
		$v_users[]=$nn;
	}
	
	
	$db->close();
	
	TemplatePage('AdminUsersOfAContest',[	'Index'=>'index.php',
											'Amministrazione'=>'AdminAdministration.php',
											'Gare'=>'AdminContests.php',
											$v_contest['name']=>'AdminContestInformation.php?ContestId='.$ContestId,
											'Correttori'=>'AdminUsersOfAContest.php?ContestId='.$ContestId]);
?>