<?php
require_once '../Utilities.php';
SuperRequire_once('General','SessionManager.php');
SuperRequire_once('General','sqlUtilities.php');
SuperRequire_once('General','PermissionManager.php');


function AddContestant( $db , $name, $surname ){
	if( !is_string($name) or strlen( $name ) > ContestantName_MAXLength or strlen( $name ) == 0) {
		return ['type'=>'bad', 'text'=>'Il nome deve essere una stringa di alpiù '.ContestantName_MAXLength.' caratteri'];
	}
	
	if( !is_string($surname) or strlen( $surname ) > ContestantSurname_MAXLength or strlen( $surname ) == 0 ) {
		return ['type'=>'bad', 'text'=>'Il cognome deve essere una stringa di alpiù '.ContestantSurname_MAXLength.' caratteri'];
	}

	Query( $db,QueryInsert('Contestants', ['name'=>$name,'surname'=>$surname]) );

	return ['type'=>'good', 'text'=>'Partecipante creato con successo', 'ContestantId'=> $db->insert_id];
}

function RemoveContestant( $db , $ContestantId ){
	
	$result=OneResultQuery($db, QuerySelect('Contestants', ['id'=>$ContestantId]) );
	if( is_null($result) ){
		return ['type'=>'bad' ,'text'=>'Il partecipante selezionato non esiste'];
	}

	Query( $db,QueryDelete('Contestants', ['id'=>$ContestantId]) );

	return ['type'=>'good', 'text'=>'Partecipante eliminato con successo'];
}

//TODO: Implementare che si faccia l'aggiunta via id e non nome e cognome
function AddParticipation( $db , $name , $surname , $ContestId ) {
	
	$Exist1=OneResultQuery($db,QuerySelect('Contestants',['name'=>$name, 'surname'=>$surname]));
	if( is_null( $Exist1 ) ) {
		return ['type'=>'bad' ,'text'=>'Il partecipante selezionato non esiste'];
	}
	
	$ContestantId=$Exist1['id'];
	
	$Exist2=OneResultQuery($db,QuerySelect('Contests',['id'=>$ContestId]));
	if( is_null( $Exist2 ) ) {
		return ['type'=>'bad' ,'text'=>'La gara selezionata non esiste'];
	}
	
	$Exist3=OneResultQuery($db,QuerySelect('Participations',['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]));
	if( !is_null( $Exist3 ) ) {
		return ['type'=>'bad' ,'text'=>'La partecipazione scelta è già presente'];
	}
	
	Query($db, QueryInsert('Participations',['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]));
	return ['type'=>'good' ,'text'=>'La partecipazione è stata aggiunta con successo', 'ContestantId'=> $ContestantId];
	
}

function RemoveParticipation( $db , $ContestantId , $ContestId ) {
	$Exist1=OneResultQuery($db,QuerySelect('Participations',['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]));
	if( is_null($Exist1) ){
		return ['type'=>'bad' ,'text'=>'La partecipazione selezionata non esiste'];
	}
	
	Query($db,QueryDelete('Participations',['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]));
	return ['type'=>'good' ,'text'=>'La partecipazione è stata eliminata con successo', 'ContestantId'=>$ContestantId];
}

function ChangeNameAndSurname($db , $ContestantId, $name, $surname) {
	$Exist1=OneResultQuery($db,QuerySelect('Contestants',['id'=>$ContestantId]));
	if( is_null( $Exist1 ) ) {
		return ['type'=>'bad' ,'text'=>'Il partecipante selezionato non esiste'];
	}
	
	if( !is_string($name) or strlen( $name ) > ContestantName_MAXLength or strlen( $name ) == 0) {
		return ['type'=>'bad', 'text'=>'Il nome deve essere una stringa di alpiù '.ContestantName_MAXLength.' caratteri'];
	}
	
	if( !is_string($surname) or strlen( $surname ) > ContestantSurname_MAXLength or strlen( $surname ) == 0 ) {
		return ['type'=>'bad', 'text'=>'Il cognome deve essere una stringa di alpiù '.ContestantSurname_MAXLength.' caratteri'];
	}
	
	Query( $db, QueryUpdate('Contestants', ['id'=>$ContestantId], ['name'=>$name, 'surname'=>$surname]));
	return ['type'=>'good', 'text'=>'Nome e cognome del partecipanti sono stati modificati con successo'];
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
else if( $data['type'] == 'ChangeNameAndSurname' ) echo json_encode( ChangeNameAndSurname( $db, $data['ContestantId'], $data['name'], $data['surname'] ) );
else echo json_encode( ['type'=>'bad', 'text'=>'L\'azione scelta non esiste'] );


$db -> close();
?>
