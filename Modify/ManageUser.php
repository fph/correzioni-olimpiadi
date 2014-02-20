<?php
require_once '../Utilities.php';
SuperRequire_once('General','SessionManager.php');
SuperRequire_once('General','sqlUtilities.php');
SuperRequire_once('General','PermissionManager.php');

//BUG: accenti e apostrofi non sono accettati (magari virgole per cognomi assurdi)
function AddUser( $db , $username, $password ){
	if( !is_string($username) or strlen( $username )>username_MAXLength or strlen( $username )<username_MINLength ) {
		return ['type'=>'bad', 'text'=>'Lo username deve essere una stringa con un numero di caratteri tra '.username_MINLength.' e '.username_MAXLength];
	}
	
	if( !is_string($password) or strlen( $password )>password_MAXLength or strlen( $password )<password_MINLength ) {
		return ['type'=>'bad', 'text'=>'La password deve essere una stringa con un numero di caratteri tra '.password_MINLength.' e '.password_MAXLength];
	}
	
	$UsernameDuplicate=OneResultQuery($db,QuerySelect('Users',['username'=>$username]));
	if( !is_null( $UsernameDuplicate ) ) {
		return ['type'=>'bad', 'text'=>'È già presente un correttore con lo stesso username'];
	}

	Query( $db,QueryInsert('Users', ['username'=>$username,'passHash'=>passwordHash($password) ]) );
	
	return ['type'=>'good', 'text'=>'Correttore creato con successo', 'UserId'=>$db->insert_id];
}

function RemoveUser( $db , $UserId ){
	
	$result=OneResultQuery($db, QuerySelect('Users', ['id'=>$UserId]) );
	if( is_null($result) ){
		return ['type'=>'bad' ,'text'=>'Il correttore selezionato non esiste'];
	}
	
	if( IsAdmin($db,$UserId) ) {
		return ['type'=>'bad' ,'text'=>'Non hai i permessi per cancellare un admin'];
	}
	
	Query( $db,QueryDelete('Users', ['id'=>$UserId]) );

	return ['type'=>'good', 'text'=>'Correttore eliminato con successo', 'UserId'=>$UserId];
	
}

function AddPermission( $db , $UserId , $ContestId ) {
	
	$Exist1=OneResultQuery($db,QuerySelect('Users',['id'=>$UserId]));
	if( is_null( $Exist1 ) ) {
		return ['type'=>'bad' ,'text'=>'Il correttore selezionato non esiste'];
	}
	
	$Exist2=OneResultQuery($db,QuerySelect('Contests',['id'=>$ContestId]));
	if( is_null( $Exist2 ) ) {
		return ['type'=>'bad' ,'text'=>'La gara selezionata non esiste'];
	}
	
	$Permission=VerifyPermission($db,$UserId,$ContestId);
	if( $Permission==1 ) {
		return ['type'=>'bad' ,'text'=>'Il permesso scelto è già presente'];
	}
	
	Query($db, QueryInsert('Permissions',['ContestId'=>$ContestId, 'UserId'=>$UserId]));
	return ['type'=>'good' ,'text'=>'Il permesso è stato aggiunto con successo'];
	
}

function RemovePermission( $db , $UserId , $ContestId ) {
	if( IsAdmin($db, $UserId) == 1 ) {
		return ['type'=>'bad', 'text'=>'Non puoi togliere permessi ad un admin'];
	}
	
	$Exist1=OneResultQuery($db,QuerySelect('Permissions',['ContestId'=>$ContestId, 'UserId'=>$UserId]));
	if( is_null($Exist1) ){
		return ['type'=>'bad' ,'text'=>'Il permesso selezionato non esiste'];
	}
	
	Query($db,QueryDelete('Permissions',['ContestId'=>$ContestId, 'UserId'=>$UserId]));
	return ['type'=>'good' ,'text'=>'Il permesso è stato eliminato con successo'];
}

function ChangeUsername( $db , $UserId , $username ) {
	if( !is_string($username) or strlen( $username )>username_MAXLength or strlen( $username )<username_MINLength ) {
		return ['type'=>'bad', 'text'=>'Lo username deve essere una stringa con un numero di caratteri tra '.username_MINLength.' e '.username_MAXLength];
	}
	
	$UsernameDuplicate=OneResultQuery($db,QuerySelect('Users',['username'=>$username]));
	if( !is_null( $UsernameDuplicate ) ) {
		return ['type'=>'bad', 'text'=>'È già presente un correttore con lo stesso username'];
	}
	
	if( IsAdmin($db,$UserId) ) {
		return ['type'=>'bad' ,'text'=>'Non hai i permessi per cambiare username ad un admin'];
	}
	
	$Exist1=OneResultQuery($db,QuerySelect('Users',['id'=>$UserId]));
	if( is_null( $Exist1 ) ) {
		return ['type'=>'bad' ,'text'=>'Il correttore selezionato non esiste'];
	}

	Query( $db,QueryUpdate('Users', ['id'=>$Userid] , ['username'=> $username ]) );
	
	return ['type'=>'good', 'text'=>'Lo username è stato cambiato con successo'];
}

function ChangePassword( $db , $UserId, $password ){
	if( !is_string($password) or strlen( $password )>password_MAXLength or strlen( $username )<4 ) {
		return ['type'=>'bad', 'text'=>'La password deve essere una stringa con un numero di caratteri tra '.password_MINLength.' e '.password_MAXLength];
	}
	
	if( IsAdmin($db,$UserId) ) {
		return ['type'=>'bad' ,'text'=>'Non hai i permessi per cambiare la password di un admin'];
	}
	
	$Exist1=OneResultQuery($db,QuerySelect('Users',['id'=>$UserId]));
	if( is_null( $Exist1 ) ) {
		return ['type'=>'bad' ,'text'=>'Il correttore selezionato non esiste'];
	}
	
	Query( $db,QueryUpdate('Users', ['id'=>$Userid] , ['passHash'=>passwordHash($password)]) );
	
	return ['type'=>'good', 'text'=>'Password cambiata con successo'];
}

$db= OpenDbConnection();
if( IsAdmin( $db, GetUserIdBySession() ) == 0 ) {
	$db -> close();
	echo json_encode( ['type'=>'good', 'text'=>'Non hai i permessi per gestire i correttori'] );
	die();
}

$data=json_decode( $_POST['data'] , 1);
if( $data['type'] == 'add' ) echo json_encode( AddUser( $db, $data['username'], $data['password'] ) );
else if( $data['type'] == 'remove' ) echo json_encode( RemoveUser( $db, $data['UserId'] ) );
else if( $data['type'] == 'AddPermission' ) echo json_encode( AddPermission( $db, $data['UserId'], $data['ContestId'] ) );
else if( $data['type'] == 'RemovePermission' ) echo json_encode( RemovePermission( $db, $data['UserId'], $data['ContestId'] ) );
else if( $data['type'] == 'ChangeUsername' ) echo json_encode( ChangeUsername( $db, $data['UserId'], $data['username'] ) );
else if( $data['type'] == 'ChangePassword' ) echo json_encode( ChangePassword( $db, $data['UserId'], $data['password'] ) );
else echo json_encode( ['type'=>'bad', 'text'=>'L\'azione scelta non esiste'] );


$db -> close();
?>
