<?php
require_once '../Utilities.php';
SuperRequire_once('General','SessionManager.php');
SuperRequire_once('General','sqlUtilities.php');
SuperRequire_once('General','PermissionManager.php');

//BUG: accenti e apostrofi non sono accettati (magari virgole per cognomi assurdi)
function AddContestant( $db , $name, $surname ){
	if( !is_string($name) or !is_string($surname) or !ctype_alpha($name) or !ctype_alpha($surname) ) {
		return ['type'=>'bad', 'text'=>'Nome e cognome devono essere stringhe di sole lettere'];
	}
	
	if( strlen($name)<2 or strlen($surname)<2) {
		return ['type'=>'bad', 'text'=>'Nome e cognome devono avere almeno due lettere'];
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

function AddParticipation( $db , $ContestantId , $ContestId ) {
	
	$Exist1=OneResultQuery($db,QuerySelect('Contestants',['id'=>$ContestantId]));
	if( is_null( $Exist1 ) ) {
		return ['type'=>'bad' ,'text'=>'Il partecipante selezionato non esiste'];
	}
	
	$Exist2=OneResultQuery($db,QuerySelect('Contests',['id'=>$ContestId]));
	if( is_null( $Exist2 ) ) {
		return ['type'=>'bad' ,'text'=>'La gara selezionata non esiste'];
	}
	
	$Exist3=OneResultQuery($db,QuerySelect('Participations',['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]));
	if( !is_null( $Exist3 ) ) {
		return ['type'=>'bad' ,'text'=>'La partecipazione scelta è già presente'];
	}
	
	Query($db, QueryInsert('Participations',['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]));
	return ['type'=>'good' ,'text'=>'La partecipazione è stata aggiunta con successo'];
	
}

function RemoveParticipation( $db , $ContestantId , $ContestId ) {
	$Exist1=OneResultQuery($db,QuerySelect('Participations',['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]));
	if( is_null($Exist1) ){
		return ['type'=>'bad' ,'text'=>'La partecipazione selezionata non esiste'];
	}
	
	Query($db,QueryDelete('Participations',['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]));
	return ['type'=>'good' ,'text'=>'La partecipazione è stata eliminata con successo'];
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
else echo json_encode( ['type'=>'bad', 'text'=>'L\'azione scelta non esiste'] );


$db -> close();
?>
