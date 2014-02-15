<?php
require_once '../Utilities.php';
SuperRequire_once('General','SessionManager.php');
SuperRequire_once('General','sqlUtilities.php');
SuperRequire_once('General','PermissionManager.php');

$db=OpenDbConnection();

$data=json_decode( $_POST['data'] , 1);
$username=$data['username'];
$password=$data['password'];

$Permission=IsAdmin( $db, GetUserIdBySession() );

if( $Permission==0 ) {
	$db->close();
	echo json_encode( ['type'=>'bad', 'text'=>'Non hai i permessi per aggiungere un correttore'] );
	die();
}

//TODO: Controllare che lo username sia valido?

$UsernameDuplicate=OneResultQuery($db,QuerySelect('Users',['username'==$username]));

if( !is_null( $UsernameDuplicate ) ) {
	$db->close();
	echo json_encode( ['type'=>'bad', 'text'=>'È già presente un correttore con lo stesso username'] );
	die();
}

if( strlen( $password ) < 4 ) {
	$db->close();
	echo json_encode( ['type'=>'bad', 'text'=>'La password deve avere almeno 4 caratteri'] );
	die();
}

Query( $db,QueryInsert('Users', ['username'=>$username,'passHash'=>passwordHash($password) ]) );

$db->close();
echo json_encode( ['type'=>'good', 'text'=>'Correttore creato con successo'] );
?>

<?php
require_once '../Utilities.php';
SuperRequire_once('General','SessionManager.php');
SuperRequire_once('General','sqlUtilities.php');
SuperRequire_once('General','PermissionManager.php');

//BUG: accenti e apostrofi non sono accettati (magari virgole per cognomi assurdi)
function AddUser( $db , $username, $password ){
	if( !is_string($username) or !is_string($password) ) {
		return ['type'=>'bad', 'text'=>'Username e password devono essere stringhe'];
	}
	
	
	$UsernameDuplicate=OneResultQuery($db,QuerySelect('Users',['username'==$username]));
	if( !is_null( $UsernameDuplicate ) ) {
		$db->close();
		echo json_encode( ['type'=>'bad', 'text'=>'È già presente un correttore con lo stesso username'] );
		die();
	}

	if( strlen( $password ) < 4 ) {
		$db->close();
		return ['type'=>'bad', 'text'=>'La password deve avere almeno 4 caratteri'];
		die();
	}

	Query( $db,QueryInsert('Users', ['username'=>$username,'passHash'=>passwordHash($password) ]) );

	$db->close();
	return ['type'=>'good', 'text'=>'Correttore creato con successo'];
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

	return ['type'=>'good', 'text'=>'Correttore eliminato con successo'];
	
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
	
	$Permission=VerifyPermission($db,$Userid,$ContestId);
	if( $Permission==1 ) {
		return ['type'=>'bad' ,'text'=>'Il permesso scelto è già presente'];
	}
	
	Query($db, QueryInsert('Permissions',['ContestId'=>$ContestId, 'UserId'=>$UserId]));
	return ['type'=>'good' ,'text'=>'Il permesso è stato aggiunto con successo'];
	
}

function RemovePermission( $db , $UserId , $ContestId ) {
	$Exist1=OneResultQuery($db,QuerySelect('Permissions',['ContestId'=>$ContestId, 'UserId'=>$UserId]));
	if( is_null($Exist1) ){
		return ['type'=>'bad' ,'text'=>'Il permesso selezionato non esiste'];
	}
	
	Query($db,QueryDelete('Permissions',['ContestId'=>$ContestId, 'UserId'=>$UserId]));
	return ['type'=>'good' ,'text'=>'Il permesso è stato eliminato con successo'];
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
else echo json_encode( ['type'=>'bad', 'text'=>'L\'azione scelta non esiste'] );


$db -> close();
?>
