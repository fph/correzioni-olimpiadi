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
	
	$v_admin=false;
	$v_contests=[];
	
	if(!is_null(OneResultQuery($db, QuerySelect('Administrators', ['UserId'=>$UserId]))) ) {
		$v_admin=true;
		$v_contests=ManyResultQuery($db, QuerySelect('Contests'));
		usort($v_contests, build_sorter('date'));
	}
	else {
		$contests=ManyResultQuery($db, QuerySelect('Permissions', ['UserId'=>$UserId]));
		foreach($contests as $con) {
			$v_contests[]=OneResultQuery($db, QuerySelect('Contests', ['id'=>$con['ContestId']]));
			usort($v_contests, build_sorter('date'));
		}
	}
	
	$db->close();
	
	TemplatePage("AdminUserInformation",[	'Index'=>'index.php',
											'Amministrazione'=>'AdminAdministration.php',
											'Correttori'=>'AdminUsers.php',
											$v_user['username']=>'AdminUserInformation.php?UserId='.$UserId]);
?>
