<?php
require_once '../Utilities.php';
SuperRequire_once('General','SessionManager.php');
SuperRequire_once('General','sqlUtilities.php');
SuperRequire_once('General','PermissionManager.php');
	
function AddContest($db, $name, $date) {
	if( !is_string( $name ) or strlen( $name )<=1 or strlen( $name )>ContestName_MAXLength ) {
		return ['type'=>'bad', 'text'=>'Il nome della gara deve essere una stringa con un numero di caratteri compreso tra 1 e '.ContestName_MAXLength];
	}
	
	Query($db, QueryInsert('Contests',['name'=>$name, 'date'=>$date, 'blocked'=>0]));
	return ['type'=>'good', 'text'=>'La gara è stata creata con successo', 'ContestId'=>$db->insert_id] ;
}

function RemoveContest($db, $ContestId) {
	$Exist1=OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	if( is_null($Exist1) ) {
		return ['type'=>'bad', 'text'=>'La gara scelta non esiste'];
	}
	
	Query($db, QueryDelete('Contests', ['id'=>$ContestId]));
	return ['type'=>'good', 'text'=>'La gara è stata eliminata con successo'];
}

function BlockContest($db, $ContestId) {
	$Exist1=OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	if( is_null($Exist1) ) {
		return ['type'=>'bad', 'text'=>'La gara scelta non esiste'];
	}
	if( $Exist1['blocked']==1 ) {
		return ['type'=>'bad', 'text'=>'La gara scelta è già bloccata'];
	}
	
	Query($db, QueryUpdate('Contests', ['id'=>$ContestId], ['blocked'=>1]));
	return ['type'=>'good', 'text'=>'La gara è stata bloccata con successo'];
}

function UnblockContest($db, $ContestId) {
	$Exist1=OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	if( is_null($Exist1) ) {
		return ['type'=>'bad', 'text'=>'La gara scelta non esiste'];
	}
	if( $Exist1['blocked']==0 ) {
		return ['type'=>'bad', 'text'=>'La gara scelta non è bloccata'];
	}
	
	Query($db, QueryUpdate('Contests', ['id'=>$ContestId], ['blocked'=>0]));
	return ['type'=>'good', 'text'=>'La gara è stata sbloccata con successo'];
}

function ChangeName($db, $ContestId, $name) {
	if( !is_string( $name ) or strlen( $name )<=1 or strlen( $name )>ContestName_MAXLength ) {
		return ['type'=>'bad', 'text'=>'Il nome della gara deve essere una stringa con un numero di caratteri compreso tra 1 e '.ContestName_MAXLength];
	}
	
	$Exist1=OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	if( is_null($Exist1) ) {
		return ['type'=>'bad', 'text'=>'La gara scelta non esiste'];
	}
	
	Query( $db, QueryUpdate('Contests', ['id'=>$ContestId], ['name'=>$name]));
	return ['type'=>'good', 'text'=>'Il nome è stato cambiato con successo'];
}

function ChangeDate($db, $ContestId, $date) {
	$Exist1=OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	if( is_null($Exist1) ) {
		return ['type'=>'bad', 'text'=>'La gara scelta non esiste'];
	}
	
	Query( $db, QueryUpdate('Contests', ['id'=>$ContestId], ['date'=>$date]));
	return ['type'=>'good', 'text'=>'La data è stata cambiata con successo'];
}

	
	
$db= OpenDbConnection();
if( IsAdmin( $db, GetUserIdBySession() ) == 0 ) {
	$db -> close();
	echo json_encode( ['type'=>'good', 'text'=>'Non hai i permessi per gestire i partecipanti'] );
	die();
}

$data=json_decode( $_POST['data'] , 1);
if( $data['type'] == 'add' ) echo json_encode( AddContest( $db, $data['name'], $data['date'] ) );
else if( $data['type'] == 'remove' ) echo json_encode( RemoveContest( $db, $data['ContestId'] ) );
else if( $data['type'] == 'block' ) echo json_encode( BlockContest( $db, $data['ContestId'] ) );
else if( $data['type'] == 'unblock' ) echo json_encode( UnblockContest( $db, $data['ContestId'] ) );
else if( $data['type'] == 'ChangeName' ) echo json_encode( ChangeName( $db, $data['ContestId'] , $data['name']) );
else if( $data['type'] == 'ChangeDate' ) echo json_encode( ChangeDate( $db, $data['ContestId'] , $data['date']) );
else echo json_encode( ['type'=>'bad', 'text'=>'L\'azione scelta non esiste'] );

$db -> close();
?>
