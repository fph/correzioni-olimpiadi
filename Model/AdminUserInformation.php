<?php
	
	require_once '../Utilities.php';
	SuperRequire_once('General','sqlUtilities.php');
	SuperRequire_once('General', 'TemplateCreation.php');
	SuperRequire_once('General', 'PermissionManager.php');
	
	$db=OpenDbConnection();
	
	CheckPagePermission($db,-1);
	
	//PermissionChecked	
	
	$UserId=$_GET['UserId'];
	
	$v_role=UserRole($db, GetUserIdBySession());
	$v_user=OneResultQuery($db, QuerySelect('Users', ['id'=>$UserId]));
	
	$v_contests=[];
	
	//The query is different if admin or not
	if( $v_user['role'] == 0) {
		$contests=ManyResultQuery($db, QuerySelect('Permissions', ['UserId'=>$UserId]));
		foreach($contests as $con) {
			$v_contests[]=OneResultQuery($db, QuerySelect('Contests', ['id'=>$con['ContestId']]));
		}
	}
	else {
		$v_contests=ManyResultQuery($db, QuerySelect('Contests'));
	}
	
	$db->close();
	
	TemplatePage('AdminUserInformation',[	'Index'=>'index.php',
											'Amministrazione'=>'AdminAdministration.php',
											'Correttori'=>'AdminUsers.php',
											$v_user['username']=>'AdminUserInformation.php?UserId='.$UserId]);
?>
