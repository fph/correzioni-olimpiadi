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
