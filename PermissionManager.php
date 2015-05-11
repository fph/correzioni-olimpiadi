<?php
require_once 'Utilities.php';
SuperRequire_once('General', 'SessionManager.php');
SuperRequire_once('General', 'sqlUtilities.php');
SuperRequire_once('General', 'TemplateCreation.php');


function UserRole($db, $UserId) {
	$user = OneResultQuery($db, QuerySelect('Users', ['id'=>$UserId]), ['role']);
	if (is_null($user)) return -1;
	return $user['role']; 
}

function IsAdmin($db, $UserId) {//Return true if user is admin or superadmin
	$user = OneResultQuery($db, QuerySelect('Users', ['id'=>$UserId]));
	if (is_null($user) or $user['role'] == 0) return 0;
	else return 1;
}

function IsSuperAdmin($db, $UserId) {
	$user = OneResultQuery($db, QuerySelect('Users', ['id'=>$UserId]));
	if (is_null($user) or $user['role'] != 2) return 0;
	else return 1;
}

function VerifyPermission($db, $UserId, $ContestId) {
	if (IsAdmin($db, $UserId)) return 1;
	$result = OneResultQuery($db, QuerySelect('Permissions', ['UserId'=>$UserId, 'ContestId'=>$ContestId], ['id']));
	if (is_null($result)) return 0;
	else return 1;
}

function CheckPagePermission($db, $ContestId) {//$ContestId == -1 means admin.
	if ($ContestId >= 0 and VerifyPermission($db, GetUserIdBySession(), $ContestId) == 0) {
		SuperRedirect('Model', 'index.php');
		die();
	}
	else if ($ContestId == -1 and IsAdmin($db, GetUserIdBySession()) == 0) {
		SuperRedirect('Model', 'index.php');
		die();
	}
}
