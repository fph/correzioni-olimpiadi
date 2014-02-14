<?php
require_once '../Utilities.php';
SuperRequire_once('General','SessionManager.php');
SuperRequire_once('General','sqlUtilities.php');

$data=json_decode( $_POST['data'] , 1);
$ContestantId=$data['ContestantId'];
$ProblemId=$data['ProblemId'];
$mark=$data['mark'];
$comment=$data['comment'];

$db=OpenDbConnection();
$ContestId=OneResultQuery($db, QuerySelect( 'Problems', ['id'=>$ProblemId], ['ContestId'] ))['ContestId'];

if( is_null( $ContestId ) ) {
	$db->close();
	echo json_encode( ['type'=>'bad', 'text'=>'La gara scelta non esiste'] );
	die();
}

$Permission=VerifyPermission( $db, GetUserIdBySession() , $ContestId ) or IsAdmin( $db, GetUserIdBySession() );

if( $Permission==0 ) {
	$db->close();
	echo json_encode( ['type'=>'bad', 'text'=>'Non hai i permessi per correggere questa gara'] );
	die();
}

if( is_null( $mark ) ) { //TODO: Controllare che sia un voto numerico o quasi
	$db->close();
	echo json_encode( ['type'=>'bad', 'text'=>'Devi scegliere un voto prima di salvare la correzione'] );
	die();
}

$ParticipationId= OneResultQuery ($db, QuerySelect('Participations', ['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]) ) ;
if( is_null ( $ParticipationId ) ) {
	$db->close();
	echo json_encode( ['type'=>'bad', 'text'=>'Il partecipante selezionato non ha partecipato alla gara'] );
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

$db->close();
echo json_encode( ['type'=>'good', 'text'=>'Correzione salvata con successo'] );
?>
