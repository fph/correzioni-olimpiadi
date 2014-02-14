<?php
require_once '../Utilities.php';
SuperRequire_once('General','SessionManager.php');
SuperRequire_once('General','AskInformation.php');

$data=json_decode( $_POST['data'] );
$ContestantId=$data['ContestantId'];
$ProblemId=$data['ProblemId'];
$Mark=$data['mark'];
$Comment=$data['comment'];

$db=OpenDbConnection();
$ContestId=OneResultQuery($db, QuerySelect( 'Problems', ['id'=>$ProblemId], ['ContestId'] ))['ContestId'];

if( is_null( $ContestId ) ) {
	$db->close();
	echo json_encode( ['type'=>'bad', 'text'=>'Il contest scelto non esiste'] );
	die();
}

$Permission=VerifyPermissions( $db, GetUserIdBySession() , $ContestId );

if( $Permission==0 ) {
	$db->close();
	echo json_encode( ['type'=>'bad', 'text'=>'Non hai i permessi per correggere questo contest'] );
	die();
}

if( is_null( 'mark' ) ) {
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
	['ProblemId'=>$ProblemId, 'ContestantId'=>$ContestantId, 'mark'=>$mark, 'comment'=>$comment, 'UserId'=>$GetUserIdBySession() ]) );
}

else {
	if( $mark == $Correction['mark'] ) Query( $db,QueryUpdate('Corrections', ['id'=>$Correction['id']] , ['comment'=>$comment]) );
	else Query( $db,QueryUpdate('Corrections', ['id'=>$Correction['id']] , ['mark'=>$mark, 'comment'=>$comment, 'UserId'=>$GetUserIdBySession() ]) );
}
?>
