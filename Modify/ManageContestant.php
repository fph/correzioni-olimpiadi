<?php
require_once '../Utilities.php';
SuperRequire_once('General','SessionManager.php');
SuperRequire_once('General','sqlUtilities.php');
SuperRequire_once('General','PermissionManager.php');

function AddContestant( $db , $name, $surname ){

	//TODO: Controllare che nome e cognome siano solo lettere (eventualmente con maiuscole?)

	Query( $db,QueryInsert('Contestants', ['name'=>$name,'surname'=>$surname]) );

	return ['type'=>'good', 'text'=>'Partecipante creato con successo'];
}

function RemoveContestant( $db , $ContestantId ){
	
	$result=OneResultQuery($db, QuerySelect('Contestants', ['id'=>$ContestantId]) );
	if( is_null($result) ){
		return ['type'=>'bad' ,'text'=>'Il partecipante selezionato non esiste'];
	}

	Query( $db,QueryDelete('Contestants', ['id'=>$ContestantId]) );

	return json_encode( ['type'=>'good', 'text'=>'Partecipante eliminato con successo'] );
}

$db= OpenDbConnection();
if( IsAdmin( $db, GetUserIdBySession() ) == 0 ) {
	$db -> close();
	echo json_encode( ['type'=>'good', 'text'=>'Non hai i permessi per gestire i partecipanti'] );
	die();
}

$data=json_decode( $_POST['data'] , 1);
if( $data['type'] == 'add' ) echo json_encode( AddContestant( $db, $data['name'], $data['surname'] ) );
else if( $data['type'] == 'remove' ) echo json_encode( RemoveContestant( $db, $data['ContestantId'] ) );
else if( $data['type'] == 'AddParticipation' ) echo json_encode( AddParticipation( $db, $data['ContestantId'], $data['ContestId'] ) );
else if( $data['type'] == 'RemoveParticipation' ) echo json_encode( RemoveParticipation( $db, $data['ContestantId'], $data['ContestId'] ) );

$db -> close();
?>
