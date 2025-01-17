<?php
require_once '../Utilities.php';
SuperRequire_once('General', 'sqlUtilities.php');
SuperRequire_once('Modify', 'ObjectSender.php');

function ValidateSolutions($PdfFile) {
	if (is_array($PdfFile['error']) or $PdfFile['error'] !== UPLOAD_ERR_OK) {
		return ['type'=>'bad', 'text'=>'C\'è stato un errore nell\'upload del file delle soluzioni'];
	}
	
	if ($PdfFile['size'] > solutions_MAXSize*1000000) {
		return ['type'=>'bad', 'text'=>'Il file delle soluzioni può pesare alpiù '.solutions_MAXSize.'MB'];
	}

	$finfo = new finfo(FILEINFO_MIME_TYPE);
	if ($finfo->file($PdfFile['tmp_name']) !== 'application/pdf') {
		return ['type'=>'bad', 'text'=>'Il file delle soluzioni deve essere in formato pdf'];
	}
	
	return ['type'=>'good'];
}

function ValidateVolunteerRequest($PdfFile) {
	if (is_array($PdfFile['error']) or $PdfFile['error'] !== UPLOAD_ERR_OK) {
		return ['type'=>'bad', 'text'=>'C\'è stato un errore nell\'upload della richiesta di partecipazione'];
	}
	
	if ($PdfFile['size'] > VolunteerRequest_MAXSize*1000000) {
		return ['type'=>'bad', 'text'=>'Il file della richiesta di partecipazione può pesare alpiù '.VolunteerRequest_MAXSize.'MB'];
	}

	$finfo = new finfo(FILEINFO_MIME_TYPE);
	if ($finfo->file($PdfFile['tmp_name']) !== 'application/pdf') {
		return ['type'=>'bad', 'text'=>'Il file della richiesta di partecipazione deve essere in formato pdf'];
	}
	
	return ['type'=>'good'];
}

function ValidateParticipation($db, $ContestantId, $ContestId, $StagesNumber,$PaidVolunteer, $solutions, $VolunteerRequest) {
	// Check existence of the contestant
	$contestant = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$ContestantId]));
	if (is_null($contestant)) {
		return ['type'=>'bad', 'text'=>'Il partecipante non esiste'];
	}
	
	// Check contest
	$contest = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	if (is_null($contest)) {
		return ['type'=>'bad', 'text'=>'La gara selezionata non esiste'];
	}
	
	$Deadline = new Datetime($contest['date']);
	if ((new Datetime('now'))->setTime(0, 0, 0) > $Deadline) {
		return ['type'=>'bad', 'text'=>'È terminato il periodo in cui era possibile iscriversi alla gara selezionata'];
	}
	
	// Check StagesNumber
	if (!is_numeric($StagesNumber) or intval($StagesNumber) < 0 or 20 < intval($StagesNumber)) {
		return ['type'=>'bad', 'text'=>'Il numero di partecipazioni a stage passati deve essere un numero tra 0 e 20'];
	}
	
	// Check PaidVolunteer
	if ($PaidVolunteer !== 'paid' and $PaidVolunteer !== 'volunteer') {
		return ['type'=>'bad', 'text'=>'Non è stato specificato se \'volontario\' o \'spesato\''];
	}
	
	// Check participation doesn't exist already
	$participation = OneResultQuery($db, QuerySelect('Participations', ['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]));
	if (!is_null($participation)) {
		return ['type'=>'bad', 'text'=>'Il partecipante già è iscritto alla gara'];
	}
	
	$SolutionsValidation = ValidateSolutions($solutions);
	if ($SolutionsValidation['type'] === 'bad') {
		return $SolutionsValidation;
	}
	
	if ($PaidVolunteer === 'volunteer') {
		$VolunteerRequestValidation = ValidateVolunteerRequest($VolunteerRequest);
		if ($VolunteerRequestValidation['type'] === 'bad') {
			return $VolunteerRequestValidation;
		}
	}
	
	return ['type'=>'good'];
}

function CreateParticipation($db, $ContestantId, $ContestId, $StagesNumber, $PaidVolunteer, $solutions, $VolunteerRequest) {
	// Choosing filename
	$PdfName = GenerateRandomString();	
	while (file_exists(UploadDirectory.$PdfName.'.pdf')) $PdfName = GenerateRandomString();
	
	// Saving the uploaded file in the correct position
	if (!move_uploaded_file($solutions['tmp_name'], UploadDirectory.$PdfName.'.pdf')) {
		return ['type'=>'bad', 'text'=>'C\'è stato un errore nel salvataggio del file delle soluzioni'];
	}
	
	// Preparing email
	$contestant = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$ContestantId]));
	$contest = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	
	// Writing mail body
	$MailBody = '';
	if ($PaidVolunteer == 'volunteer') {
		$MailBody = 'Gentile segreteria UMI,<br>';
		$MailBody .= 'Sono '.$contestant['name'].' '.$contestant['surname'].' e scrivo per chiedere di partecipare come volontario allo stage '.$contest['name'].'.<br>';
		$MailBody .= 'La mia scuola è '.$contestant['school'].' di '.$contestant['SchoolCity'].' e il mio indirizzo email è '.$contestant['email'].'.<br>';
		$MailBody .= 'In passato ho partecipato a '.strval(intval($StagesNumber)).' stage a Pisa.<br>';
		$MailBody .= 'In allegato si trova la richiesta di partecipazione in formato pdf.<br><br>';
		$MailBody .= '<br> p.s. Questa mail è stata inviata in automatico, <u>non rispondete a questo indirizzo</u> poiché nessuno leggerebbe la risposta.';
	}
	else {
		$MailBody = 'Gentile segreteria UMI,<br>';
		$MailBody .= 'Sono '.$contestant['name'].' '.$contestant['surname'].' e scrivo per chiedere di partecipare come spesato allo stage '.$contest['name'].'.<br>';
		$MailBody .= 'La mia scuola è '.$contestant['school'].' di '.$contestant['SchoolCity'].' e il mio indirizzo email è '.$contestant['email'].'.<br>';
		$MailBody .= 'In passato ho partecipato a '.$StagesNumber.' stage a Pisa.<br><br>';
		$MailBody .= '<br> p.s. Questa mail è stata inviata in automatico, <u>non rispondete a questo indirizzo</u> poiché nessuno leggerebbe la risposta.';
	}

	// Here we are checking again if the participation exists already.
	// This tries to address issue #57, though it's not a great solution
	// as a race condition is still possible.
	$participation = OneResultQuery($db, QuerySelect('Participations', ['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]));
	if (!is_null($participation)) {
		return ['type'=>'bad', 'text'=>'Il partecipante già è iscritto alla gara'];
	}
	Query($db, QueryInsert('Participations', [
		'ContestId'=>$ContestId, 
		'ContestantId'=>$ContestantId,
		'solutions'=>$PdfName,
		'PastCamps'=>$StagesNumber
	]));
	
	// Send mail	
	$CleanedSurname = preg_replace('/[^\p{L}]/u', '', $contestant['surname']);
    // Not sending the document with the solutions as it is too big.
	$attachments = [
		['file'=>$VolunteerRequest['tmp_name'], 'name'=>'RichiestaPartecipazione_'.$CleanedSurname.'.pdf']
	];
	
	$SendingSuccess = true;
	// If ForwardRegistrationEmail is non empty, the email is sent, otherwise nothing is done.
	if (strlen($contest['ForwardRegistrationEmail']) >= 5) {
		$SendingSuccess = SendMail($contest['ForwardRegistrationEmail'], 'Richiesta di partecipazione '.$contest['name'], $MailBody, $attachments);
	}
	
	if (!$SendingSuccess) {
		Query($db, QueryDelete('Participations', [
			'ContestId'=>$ContestId, 
			'ContestantId'=>$ContestantId
		]));
		return ['type'=>'bad', 'text'=>'L\'email con la richiesta di partecipazione non è stata inviata a causa di un errore del server'];
	}
	
	// Confirmation mail
	$MailBody = 'Cara/o '.$contestant['name'].',<br>'.'Ti confermiamo che ti sei iscritto/a con successo a "'.$contest['name'].'".';
	$SendingSuccess = SendMail($contestant['email'], 'Conferma richiesta di partecipazione "'.$contest['name'].'"', $MailBody);
	
	if (!$SendingSuccess) {
		return ['type'=>'bad', 'text'=>'L\'email di conferma non è stata inviata a causa di un errore del server'];
	}
	
	return ['type'=>'good', 'text'=>'La partecipazione è stata aggiunta con successo', 'data'=>[
		'ContestantId'=>$ContestantId
	]];
	
}

$db = OpenDbConnection();

if (!isset($_POST['ContestantId']) or 
	!isset($_POST['ContestId']) or 
	!isset($_POST['code']) or 
	!isset($_POST['StagesNumber']) or 
	!isset($_POST['PaidVolunteer']) or
	!isset($_FILES['solutions']) or
	($_POST['PaidVolunteer'] === 'volunteer' and !isset($_FILES['VolunteerRequest']))
) {
	SendObject(['type'=>'bad', 'text'=>'Non sono stati forniti tutti i dati richiesti']);
	$db->close();
	die();
}

// Checking verification code
$row = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$_POST['ContestantId']]));
if (is_null($row)) {
	SendObject(['type'=>'bad', 'text'=>'Il partecipante non esiste']);
	$db->close();
	die();
}
$email = $row['email'];

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

// Validation
$validation = ValidateParticipation($db, $_POST['ContestantId'], $_POST['ContestId'], $_POST['StagesNumber'], $_POST['PaidVolunteer'], $_FILES['solutions'], $_FILES['VolunteerRequest']);
if ($validation['type'] == 'bad') {
	SendObject($validation);
	$db->close();
	die();
}

// Creation
SendObject(CreateParticipation($db, $_POST['ContestantId'], $_POST['ContestId'], $_POST['StagesNumber'], $_POST['PaidVolunteer'], $_FILES['solutions'], $_FILES['VolunteerRequest']));

$db->close();
?>
