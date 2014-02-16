<?php
require_once '../Utilities.php';
SuperRequire_once('General','SessionManager.php');
SuperRequire_once('General','sqlUtilities.php');
SuperRequire_once('General','PermissionManager.php');
	
function AddContest($db, $name, $date) {
	//TODO: Checkare nome e data?
	
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
else echo json_encode( ['type'=>'bad', 'text'=>'L\'azione scelta non esiste'] );

$db -> close();
?>
