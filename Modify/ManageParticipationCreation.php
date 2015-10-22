<?php
require_once '../Utilities.php';
SuperRequire_once('General', 'sqlUtilities.php');
require PHPMailerPath; // PhpMailer library
SuperRequire_once('Modify', 'ObjectSender.php');

function ValidateSolutions($PdfFile) {
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
	
	return ['type'=>'good'];
}

function ValidateVolunteerRequest($PdfFile) {
	if (is_array($PdfFile['error']) or $PdfFile['error'] !== UPLOAD_ERR_OK) {
		return ['type'=>'bad', 'text'=>'C\'è stato un errore nell\'upload della richiesta di partecipazione'];
	}
	
	if ($PdfFile['size'] > PdfSize_MAX*1000000) {
		return ['type'=>'bad', 'text'=>'Il file della richiesta di partecipazione può pesare alpiù '.PdfSize_MAX.'Mb'];
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
	$StagesNumber = intval($StagesNumber);
	if ($StagesNumber < 0 or 20 < $StagesNumber) {
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
	
	$mail = new PHPMailer;
	$mail->CharSet = 'UTF-8';
	
	if (EmailSMTP) {
		$mail->isSMTP();
		$mail->SMTPDebug = 0; 
		$mail->Host = EmailHost;
		$mail->Port = EmailPort;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Username = EmailUsername;
		$mail->Password = EmailPassword;
	}
	else {
		$mail->isSendmail();
	}
	$mail->setFrom(EmailAddress, 'Correzioni OliMat'); 
	$mail->addAddress(VolunteerRequestEmailAddress);
	$mail->Subject = 'Richiesta di partecipazione '.$contest['name'];
	$mail->isHTML(true);
	
	// Writing MailText
	$MailText = '';
	if ($PaidVolunteer == 'volunteer') {
		$MailText = 'Gentile segreteria UMI,<br>';
		$MailText .= 'Sono '.$contestant['name'].' '.$contestant['surname'].' e scrivo per chiedere di partecipare come volontario allo stage '.$contest['name'].'.<br>';
		$MailText .= 'La mia scuola è '.$contestant['school'].' e il mio indirizzo email è '.$contestant['email'].'.<br>';
		$MailText .= 'In passato ho partecipato a '.$StagesNumber.' stage a Pisa.<br>';
		$MailText .= 'In allegato si trova la richiesta di partecipazione in formato pdf.<br><br>';
		$MailText .= '<br> p.s. Questa mail è stata inviata in automatico, <u>non rispondete a questo indirizzo</u> poiché nessuno leggerebbe la risposta.';
	}
	else {
		$MailText = 'Gentile segreteria UMI,<br>';
		$MailText .= 'Sono '.$contestant['name'].' '.$contestant['surname'].' e scrivo per chiedere di partecipare come spesato allo stage '.$contest['name'].'.<br>';
		$MailText .= 'La mia scuola è '.$contestant['school'].' e il mio indirizzo email è '.$contestant['email'].'.<br>';
		$MailText .= 'In passato ho partecipato a '.$StagesNumber.' stage a Pisa.<br><br>';
		$MailText .= '<br> p.s. Questa mail è stata inviata in automatico, <u>non rispondete a questo indirizzo</u> poiché nessuno leggerebbe la risposta.';
	}
	
	// Send mail	
	$mail->Body = $MailText;
	$CleanedSurname = preg_replace('/[^\p{L}]/u', '', $contestant['surname']);
	$mail->AddAttachment($VolunteerRequest['tmp_name'], 'RichiestaPartecipazione_'.$CleanedSurname.'.pdf');
	if (!$mail->send()) {
		return ['type'=>'bad', 'text'=>'L\'email con la richiesta di partecipazione non è stata inviata a causa di un errore del server'];
	}

	Query($db, QueryInsert('Participations', [
		'ContestId'=>$ContestId, 
		'ContestantId'=>$ContestantId,
		'solutions'=>$PdfName
	]));
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
