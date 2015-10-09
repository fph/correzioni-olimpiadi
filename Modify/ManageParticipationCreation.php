<?php
require_once '../Utilities.php';
SuperRequire_once('General', 'sqlUtilities.php');
SuperRequire_once('Modify', 'ObjectSender.php');

function CreateParticipation($db, $ContestantId, $ContestId, $PdfFile) {
	// Check existence of the contestant
	$contestant = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$ContestantId]));
	if (is_null($contestant)) {
		return ['type'=>'bad', 'text'=>'Il partecipante non esiste'];
	}
	
	// Check existence of the contest
	$contest = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	if (is_null($contest)) {
		return ['type'=>'bad', 'text'=>'La gara selezionata non esiste'];
	}
	
	// TODO: Controllare che sia possibile iscriversi alla gara ContestId
	
	$participation = OneResultQuery($db, QuerySelect('Participations', ['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]));
	if (!is_null($participation)) {
		return ['type'=>'bad', 'text'=>'Il partecipante già è iscritto alla gara'];
	}
	
	// Validation of PdfFile
	if (is_array($PdfFile['error']) or $PdfFile['error'] !== UPLOAD_ERR_OK) {
		return ['type'=>'bad', 'text'=>'C\'è stato un errore nell\'upload del file delle soluzioni'];
	}
	
	if ($PdfFile['size'] > PdfSize_MAX*1000000) {
		return ['type'=>'bad', 'text'=>'Il file delle soluzioni può pesare alpiù '.PdfSize_MAX.'Mb'];
	}

	$finfo = new finfo(FILEINFO_MIME_TYPE);
	if ($finfo->file($PdfFile['tmp_name']) !== 'application/pdf') {
		return ['type'=>'bad', 'text'=>'Il file delle soluzioni deve essere in formato pdf'];
	}
	
	// Choosing filename
	$PdfName = bin2hex(openssl_random_pseudo_bytes(6));	
	while (file_exists('../uploads/'.$PdfName.'.pdf')) $PdfName = bin2hex(openssl_random_pseudo_bytes(6));
	
	// Saving the uploaded file in the correct position
	if (!move_uploaded_file($PdfFile['tmp_name'], '../uploads/'.$PdfName.'.pdf')) {
		return ['type'=>'bad', 'text'=>'C\'è stato un errore nella gestione del file delle soluzioni'];
	}
	
	Query($db, QueryInsert('Participations', [
		'ContestId'=>$ContestId, 
		'ContestantId'=>$ContestantId,
		'solutions'=>$PdfName
	]));
	return ['type'=>'good', 'text'=>'La partecipazione è stata aggiunta con successo', 'data'=>[
		'ContestantId'=>$ContestantId, 
		'surname'=>$contestant['surname'], 
		'name'=>$contestant['name'] 
	]];
	
}

$db = OpenDbConnection();

// Checking ContestantId
if (!isset($_POST['ContestantId']) or 
	!isset($_POST['ContestId']) or 
	!isset($_POST['code']) or 
	!isset($_POST['StagesNumber']) or 
	!isset($_POST['PaidVolunteer']) or
	!isset($_FILES['solutions'])
) {
	SendObject(['type'=>'bad', 'text'=>'Non sono stati forniti tutti i dati richiesti']);
	$db->close();
	die();
}
$row = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$_POST['ContestantId']]));
if (is_null($row)) {
	SendObject(['type'=>'bad', 'text'=>'Il partecipante non esiste']);
	$db->close();
	die();
}
$email = $row['email'];

// Checking verification code
$row = OneResultQuery($db, QuerySelect('VerificationCodes', ['email'=>$email, 'code'=>$_POST['code']]));
if (is_null($row)) {
	SendObject(['type'=>'bad', 'text'=>'Il codice di verifica non è corretto']);
	$db->close();
	die();
}
$timestamp = new Datetime($row['timestamp']);
$timestamp->add(new DateInterval('PT6H')); // sums 6 hours to the timestamp
if (new Datetime('now') > $timestamp) {
	SendObject(['type'=>'bad', 'text'=>'Il codice di verifica è scaduto']);
	$db->close();
	die();
}

// Contestant validation and creation
SendObject(CreateParticipation($db, $_POST['ContestantId'], $_POST['ContestId'], $_FILES['solutions']));

$db->close();
?>
