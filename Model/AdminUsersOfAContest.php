<?php
	
	require_once '../Utilities.php';
	SuperRequire_once('General', 'sqlUtilities.php');
	SuperRequire_once('General', 'TemplateCreation.php');
	SuperRequire_once('General', 'PermissionManager.php');
	
	$db = OpenDbConnection();
	
	CheckPagePermission($db, -1);
	
	//PermissionChecked
	
	$ContestId = $_GET['ContestId'];
	
	$v_contest = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));

	$admins = ManyResultQuery($db, QuerySelect('Users', ['role'=>1]));
	$SuperAdmins = ManyResultQuery($db, QuerySelect('Users', ['role'=>2]));
	$permissions = ManyResultQuery($db, QuerySelect('Permissions', ['ContestId'=>$ContestId]));
	
	$v_users = [];
	
	foreach ($admins as $user) {
		$v_users []= $user;
	}
	foreach ($SuperAdmins as $user) {
		$v_users []= $user;
	}
	foreach ($permissions as $permission) {
		$user = OneResultQuery($db, QuerySelect('Users', ['id'=>$permission['UserId']]));
		if ($user['role'] == 0) {
			$v_users []= $user;
		}
	}
	
	
	$db->close();
	
	TemplatePage('AdminUsersOfAContest', [	'Index'=>'index.php',
											'Amministrazione'=>'AdminAdministration.php',
											'Gare'=>'AdminContests.php',
											$v_contest['name']=>'AdminContestInformation.php?ContestId='.$ContestId,
											'Correttori'=>'AdminUsersOfAContest.php?ContestId='.$ContestId]);
?>
