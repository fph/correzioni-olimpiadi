<?php
require_once '../Utilities.php';
SuperRequire_once('General','SessionManager.php');
SuperRequire_once('General','sqlUtilities.php');
SuperRequire_once('General','PermissionManager.php');

function MakeCorrection($db, $ContestId, $ProblemId, $ContestantId, $mark, $comment) {
	if( is_null( $ContestId ) ) {
		return ['type'=>'bad', 'text'=>'La gara scelta non esiste'];
	}
	
	if( is_null( $mark ) ) { //TODO: Controllare che sia un voto numerico o quasi... attualmente può essere qualunque cosa.
		return ['type'=>'bad', 'text'=>'Devi scegliere un voto prima di salvare la correzione'];
	}
	
	if( strlen( $comment ) > comment_MAXLength ) {
		return ['type'=>'bad', 'text'=>'Il commento può avere al più '.comment_MAXLength.' caratteri, il tuo ne ha '.strlen( $comment )];
	}

	$Blocked=OneResultQuery($db, QuerySelect('Contests',['id'=>$ContestId],['blocked']))['blocked'];
	if( $Blocked==1 ) {
		return ['type'=>'bad', 'text'=>'Le correzioni della gara scelta sono terminate'];
	}

	$Permission=VerifyPermission( $db, GetUserIdBySession() , $ContestId );
	if( $Permission==0 ) {
		return ['type'=>'bad', 'text'=>'Non hai i permessi per correggere questa gara'] ;
	}
	
	$ParticipationId= OneResultQuery ($db, QuerySelect('Participations', ['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]) ) ;
	if( is_null ( $ParticipationId ) ) {
		return ['type'=>'bad', 'text'=>'Il partecipante selezionato non ha partecipato alla gara'] ;
	}

	$Correction =OneResultQuery ( $db,QuerySelect('Corrections', ['ProblemId'=>$ProblemId, 'ContestantId'=>$ContestantId]) );

	if( is_null($Correction) ) {
		Query( $db,QueryInsert('Corrections', 
		['ProblemId'=>$ProblemId, 'ContestantId'=>$ContestantId, 'mark'=>$mark, 'comment'=>$comment, 'UserId'=>GetUserIdBySession() ]) );
	}

	else {
		if( $mark == $Correction['mark'] ) Query( $db,QueryUpdate('Corrections', ['id'=>$Correction['id']] , ['comment'=>$comment]) );
		else Query( $db,QueryUpdate('Corrections', ['id'=>$Correction['id']] , ['mark'=>$mark, 'comment'=>$comment, 'UserId'=>GetUserIdBySession() ]) );
	}
	
	return ['type'=>'good', 'text'=>'Correzione salvata con successo'];
}

$data=json_decode( $_POST['data'] , 1);
$ContestantId=$data['ContestantId'];
$ProblemId=$data['ProblemId'];
$mark=$data['mark'];
$comment=$data['comment'];

$db=OpenDbConnection();
$ContestId=OneResultQuery($db, QuerySelect( 'Problems', ['id'=>$ProblemId], ['ContestId'] ))['ContestId'];

echo json_encode( MakeCorrection($db, $ContestId, $ProblemId, $ContestantId, $mark, $comment) );

$db->close();
?>
