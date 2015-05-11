<?php
require_once '../Utilities.php';
SuperRequire_once('General', 'SessionManager.php');
SuperRequire_once('General', 'sqlUtilities.php');
SuperRequire_once('General', 'PermissionManager.php');
SuperRequire_once('Modify', 'ObjectSender.php');

//Receive the request to create a user, check whether the username is already used and if both password an username satisfy some rules.
//If all is ok create the user.
function AddUser($db, $username, $password) {
	if (!is_string($username) or strlen($username)>username_MAXLength or strlen($username)<username_MINLength) {
		return ['type'=>'bad', 'text'=>'Lo username deve essere una stringa con un numero di caratteri tra '.username_MINLength.' e '.username_MAXLength];
	}
	
	if (!is_string($password) or strlen($password)>password_MAXLength or strlen($password)<password_MINLength) {
		return ['type'=>'bad', 'text'=>'La password deve essere una stringa con un numero di caratteri tra '.password_MINLength.' e '.password_MAXLength];
	}
	
	$UsernameDuplicate = OneResultQuery($db, QuerySelect('Users', ['username'=>$username]));
	if (!is_null($UsernameDuplicate)) {
		return ['type'=>'bad', 'text'=>'È già presente un correttore con lo stesso username'];
	}

	Query($db, QueryInsert('Users', ['username'=>$username, 'passHash'=>PasswordHash($password) ]));
	
	return ['type'=>'good', 'text'=>'Correttore creato con successo', 'data'=>['UserId'=>$db->insert_id, 'username'=>$username] ];
}

//Check whether the user exists and it is not admin.
//If all it's okay remove the user.
function RemoveUser($db, $UserId) {
	
	$result = OneResultQuery($db, QuerySelect('Users', ['id'=>$UserId]));
	if (is_null($result)) {
		return ['type'=>'bad', 'text'=>'Il correttore selezionato non esiste'];
	}
	
	if (IsAdmin($db, $UserId)) {
		return ['type'=>'bad', 'text'=>'Non hai i permessi per cancellare un admin'];
	}
	
	Query($db, QueryDelete('Users', ['id'=>$UserId]));

	return ['type'=>'good', 'text'=>'Correttore eliminato con successo', 'UserId'=>$UserId];
	
}

//Check whether the User and Contest exist, then if the user doesn't already have the permission.
//If all it's ok add the permission.
function AddPermission($db, $UserId, $ContestId) {
	
	$user = OneResultQuery($db, QuerySelect('Users', ['id'=>$UserId]));
	if (is_null($user)) {
		return ['type'=>'bad', 'text'=>'Il correttore selezionato non esiste'];
	}
	
	$Exist2 = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	if (is_null($Exist2)) {
		return ['type'=>'bad', 'text'=>'La gara selezionata non esiste'];
	}
	
	$Permission = VerifyPermission($db, $UserId, $ContestId);
	if ($Permission == 1) {
		return ['type'=>'bad', 'text'=>'Il permesso scelto è già presente'];
	}
	
	Query($db, QueryInsert('Permissions', ['ContestId'=>$ContestId, 'UserId'=>$UserId]));
	return ['type'=>'good', 'text'=>'Il permesso è stato aggiunto con successo', 'data'=>['UserId'=>$UserId, 'username'=>$user['username']] ];
	
}

//Check whether the permission exists and the user isn't an admin.
//If all it's ok remove the permission.
function RemovePermission($db, $UserId, $ContestId) {
	if (IsAdmin($db, $UserId) == 1) {
		return ['type'=>'bad', 'text'=>'Non puoi togliere permessi ad un admin'];
	}
	
	$Exist1 = OneResultQuery($db, QuerySelect('Permissions', ['ContestId'=>$ContestId, 'UserId'=>$UserId]));
	if (is_null($Exist1)) {
		return ['type'=>'bad', 'text'=>'Il permesso selezionato non esiste'];
	}
	
	Query($db, QueryDelete('Permissions', ['ContestId'=>$ContestId, 'UserId'=>$UserId]));
	return ['type'=>'good', 'text'=>'Il permesso è stato eliminato con successo', 'data'=>['UserId'=>$UserId]];
}

//Check whether the user exists and he's not an admin, the username isn't already used and it satisfies some standards.
//If all it's ok change the username of the user.
function ChangeUsername($db, $UserId, $username) {
	if (!is_string($username) or strlen($username)>username_MAXLength or strlen($username)<username_MINLength) {
		return ['type'=>'bad', 'text'=>'Lo username deve essere una stringa con un numero di caratteri tra '.username_MINLength.' e '.username_MAXLength];
	}
	
	$UsernameDuplicate = OneResultQuery($db, QuerySelect('Users', ['username'=>$username]));
	if (!is_null($UsernameDuplicate)) {
		return ['type'=>'bad', 'text'=>'È già presente un correttore con lo stesso username'];
	}
	
	if (IsAdmin($db, $UserId)) {
		return ['type'=>'bad', 'text'=>'Non hai i permessi per cambiare username ad un admin'];
	}
	
	$Exist1 = OneResultQuery($db, QuerySelect('Users', ['id'=>$UserId]));
	if (is_null($Exist1)) {
		return ['type'=>'bad', 'text'=>'Il correttore selezionato non esiste'];
	}

	Query($db, QueryUpdate('Users', ['id'=>$UserId], ['username'=> $username ]));
	
	return ['type'=>'good', 'text'=>'Lo username è stato cambiato con successo'];
}

//Check whether the user exists and he's not an admin and whether the password satisfies some standards.
//If all it's ok change the password of the user.
function ChangePassword($db, $UserId, $password) {
	if (!is_string($password) or strlen($password)>password_MAXLength or strlen($username)<4) {
		return ['type'=>'bad', 'text'=>'La password deve essere una stringa con un numero di caratteri tra '.password_MINLength.' e '.password_MAXLength];
	}
	
	if (IsAdmin($db, $UserId)) {
		return ['type'=>'bad', 'text'=>'Non hai i permessi per cambiare la password di un admin'];
	}
	
	$Exist1 = OneResultQuery($db, QuerySelect('Users', ['id'=>$UserId]));
	if (is_null($Exist1)) {
		return ['type'=>'bad', 'text'=>'Il correttore selezionato non esiste'];
	}
	
	Query($db, QueryUpdate('Users', ['id'=>$Userid], ['passHash'=>PasswordHash($password)]));
	
	return ['type'=>'good', 'text'=>'Password cambiata con successo'];
}

function ChangeRole($db, $UserId, $UserRole) {
	if (IsSuperAdmin($db, GetUserIdBySession()) == 0) {
		return ['type'=>'bad', 'text'=>'Non hai i permessi per cambiare il ruolo di un utente'];
	}
	
	$UserRoleNum = 0;
	if ($UserRole == 'user') $UserRoleNum=0;
	else if ($UserRole == 'admin') $UserRoleNum=1;
	else if ($UserRole == 'SuperAdmin') $UserRoleNum=2;
	else {
		return ['type'=>'bad', 'text'=>'Il ruolo scelto non esiste'];
	}
	
	$user = OneResultQuery($db, QuerySelect('Users', ['id'=>$UserId], ['role']));
	if (is_null($user)) {
		return ['type'=>'bad', 'text'=>'Il correttore selezionato non esiste'];
	}
	if ($user['role'] == 2) {
		return ['type'=>'bad', 'text'=>'Non hai i permessi per cambiare il ruolo di un super amministratore'];
	}
	if ($user['role'] == $UserRoleNum) {
		return ['type'=>'bad', 'text'=>'Il correttore ricopre già il ruolo scelto'];
	}
	Query($db, QueryUpdate('Users', ['id'=>$UserId], ['role'=>$UserRoleNum]));
	
	return ['type'=>'good', 'text'=>'Il ruolo del correttore è stato cambiato con successo'];
}

$db= OpenDbConnection();
if (IsAdmin($db, GetUserIdBySession()) == 0) {
	$db -> close();
	SendObject(['type'=>'bad', 'text'=>'Non hai i permessi per gestire i correttori']);
	die();
}

$data = json_decode($_POST['data'], 1);
if ($data['type'] == 'add') SendObject(AddUser($db, $data['username'], $data['password']));
else if ($data['type'] == 'remove') SendObject(RemoveUser($db, $data['UserId']));
else if ($data['type'] == 'AddPermission') SendObject(AddPermission($db, $data['UserId'], $data['ContestId']));
else if ($data['type'] == 'RemovePermission') SendObject(RemovePermission($db, $data['UserId'], $data['ContestId']));
else if ($data['type'] == 'ChangeUsername') SendObject(ChangeUsername($db, $data['UserId'], $data['username']));
else if ($data['type'] == 'ChangePassword') SendObject(ChangePassword($db, $data['UserId'], $data['password']));
else if ($data['type'] == 'ChangeRole') SendObject(ChangeRole($db, $data['UserId'], $data['UserRole']));
else SendObject(['type'=>'bad', 'text'=>'L\'azione scelta non esiste']);


$db -> close();
?>
