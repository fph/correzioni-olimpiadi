<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	CheckPagePermission($db,-1);
	
	//PermissionChecked	
	
	$UserId=$_GET['UserId'];
	
	$v_user=OneResultQuery($db, QuerySelect('Users', ['id'=>$UserId]));
	
	$v_contests=[];
	
	//The query is different if admin or not
	$v_admin=IsAdmin($db, $UserId);
	if( $v_admin == 1) {
		$v_contests=ManyResultQuery($db, QuerySelect('Contests'));
	}
	else {
		$contests=ManyResultQuery($db, QuerySelect('Permissions', ['UserId'=>$UserId]));
		foreach($contests as $con) {
			$v_contests[]=OneResultQuery($db, QuerySelect('Contests', ['id'=>$con['ContestId']]));
		}
	}
	
	$db->close();
	
	TemplatePage("AdminUserInformation",[	'Index'=>'index.php',
											'Amministrazione'=>'AdminAdministration.php',
											'Correttori'=>'AdminUsers.php',
											$v_user['username']=>'AdminUserInformation.php?UserId='.$UserId]);
?>
