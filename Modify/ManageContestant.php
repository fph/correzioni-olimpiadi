<?php
require_once '../Utilities.php';
SuperRequire_once('General', 'SessionManager.php');
SuperRequire_once('General', 'sqlUtilities.php');
SuperRequire_once('General', 'PermissionManager.php');
SuperRequire_once('Modify', 'ObjectSender.php');


function AddContestant($db, $name, $surname, $school, $SchoolCity, $email, $LastOlympicYear) {
	if (!is_string($name) or strlen($name) > ContestantName_MAXLength or strlen($name) == 0) {
		return ['type'=>'bad', 'text'=>'Il nome deve essere una stringa di al più '.ContestantName_MAXLength.' caratteri'];
	}
	
	if (!is_string($surname) or strlen($surname) > ContestantSurname_MAXLength or strlen($surname) == 0) {
		return ['type'=>'bad', 'text'=>'Il cognome deve essere una stringa di al più '.ContestantSurname_MAXLength.' caratteri'];
	}
	
	if (!is_string($school) or strlen($school) > ContestantSchool_MAXLength) {
		return ['type'=>'bad', 'text'=>'La scuola deve essere una stringa di al più '.ContestantSchool_MAXLength.' caratteri'];
	}
	
	if (!is_string($SchoolCity) or strlen($SchoolCity) > ContestantSchoolCity_MAXLength) {
		return ['type'=>'bad', 'text'=>'La città della scuola deve essere una stringa di al più '.ContestantSchoolCity_MAXLength.' caratteri'];
	}
	
	// TODO: Si dovrebbe fare un sanity check sulla mail (sia qui che in ChangeEmail())
	if (!is_string($email) or strlen($email) > ContestantEmail_MAXLength) {
		return ['type'=>'bad', 'text'=>'L\'email deve essere una stringa di al più '.ContestantEmail_MAXLength.' caratteri'];
	}
	
	$LastOlympicYear = intval($LastOlympicYear);

	Query($db, QueryInsert('Contestants', ['name'=>$name, 'surname'=>$surname, 'school'=>$school, 'SchoolCity'=>$SchoolCity, 'email'=>$email, 'LastOlympicYear'=>$LastOlympicYear]));

	return ['type'=>'good', 'text'=>'Partecipante creato con successo', 'data'=>[
	'ContestantId'=> $db->insert_id, 'surname'=>$surname, 'name'=>$name, 'school'=>$school, 'SchoolCity'=>$SchoolCity, 'email'=>$email, 'LastOlympicYear'=>$LastOlympicYear]];
}

function RemoveContestant($db, $ContestantId) {
	$result = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$ContestantId]));
	if (is_null($result)) {
		return ['type'=>'bad', 'text'=>'Il partecipante selezionato non esiste'];
	}

	Query($db, QueryDelete('Contestants', ['id'=>$ContestantId]));
	//TODO: All participations should be deleted?
	
	return ['type'=>'good', 'text'=>'Partecipante eliminato con successo'];
}

function AddParticipation($db, $ContestantId, $ContestId, $solutions) {
	$contestant = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$ContestantId]));
	if (is_null($contestant)) {
		return ['type'=>'bad', 'text'=>'Il partecipante selezionato non esiste'];
	}
	
	$Exist2 = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	if (is_null($Exist2)) {
		return ['type'=>'bad', 'text'=>'La gara selezionata non esiste'];
	}
	
	$Exist3 = OneResultQuery($db, QuerySelect('Participations', ['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]));
	if (!is_null($Exist3)) {
		return ['type'=>'bad', 'text'=>'La partecipazione scelta è già presente'];
	}
	
	$PdfName = null;
	if (!is_null($solutions)) {
		// Validating $solutions
		if (is_array($solutions['error']) or $solutions['error'] !== UPLOAD_ERR_OK) {
			return ['type'=>'bad', 'text'=>'C\'è stato un errore nell\'upload del file delle soluzioni'];
		}
		
		if ($solutions['size'] > PdfSize_MAX*1000000) {
			return ['type'=>'bad', 'text'=>'Il file delle soluzioni può pesare alpiù '.PdfSize_MAX.'Mb'];
		}

		$finfo = new finfo(FILEINFO_MIME_TYPE);
		if ($finfo->file($solutions['tmp_name']) !== 'application/pdf') {
			return ['type'=>'bad', 'text'=>'Il file delle soluzioni deve essere in formato pdf'];
		}
		
		// Choosing filename
		$PdfName = GenerateRandomString();	
		while (file_exists(UploadDirectory.$PdfName.'.pdf')) $PdfName = GenerateRandomString();
		
		// Saving the uploaded file in the correct position
		if (!move_uploaded_file($solutions['tmp_name'], UploadDirectory.$PdfName.'.pdf')) {
			return ['type'=>'bad', 'text'=>'C\'è stato un errore nel salvataggio del file delle soluzioni'];
		}
	}
	
	Query($db, QueryInsert('Participations', [
		'ContestId'=>$ContestId, 
		'ContestantId'=>$ContestantId,
		'solutions'=>$PdfName
	]));
	
	return ['type'=>'good', 'text'=>'La partecipazione è stata aggiunta con successo', 'data'=>[
		'ContestantId'=>$ContestantId, 
		'surname'=>$contestant['surname'], 
		'name'=>$contestant['name'],
		'SolutionsBoolean'=>(is_null($PdfName)?0:1)
	]];
}

function RemoveParticipation($db, $ContestantId, $ContestId) {
	$participation = OneResultQuery($db, QuerySelect('Participations', ['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]));
	if (is_null($participation)) {
		return ['type'=>'bad', 'text'=>'La partecipazione selezionata non esiste'];
	}
	
	// Deleting solutions pdf
	if (!is_null($participation['solutions'])) {
		unlink(UploadDirectory.$participation['solutions'].'.pdf');
	}
	
	Query($db, QueryDelete('Participations', ['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]));
	
	$ContestProblems = ManyResultQuery($db, QuerySelect('Problems', ['ContestId'=>$ContestId], ['id']));
	foreach ($ContestProblems as $problem) {
		Query($db, QueryDelete('Corrections', ['ContestantId'=>$ContestantId, 'ProblemId'=>$problem['id']]));
	}
	
	return ['type'=>'good', 'text'=>'La partecipazione è stata eliminata con successo', 'data'=>['ContestantId'=>$ContestantId] ];
}

function ChangeNameAndSurname($db, $ContestantId, $name, $surname) {
	$Exist1 = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$ContestantId]));
	if (is_null($Exist1)) {
		return ['type'=>'bad', 'text'=>'Il partecipante selezionato non esiste'];
	}
	
	if (!is_string($name) or strlen($name) > ContestantName_MAXLength or strlen($name) == 0) {
		return ['type'=>'bad', 'text'=>'Il nome deve essere una stringa non vuota di al più '.ContestantName_MAXLength.' caratteri'];
	}
	
	if (!is_string($surname) or strlen($surname) > ContestantSurname_MAXLength or strlen($surname) == 0) {
		return ['type'=>'bad', 'text'=>'Il cognome deve essere una stringa non vuota di al più '.ContestantSurname_MAXLength.' caratteri'];
	}
	
	Query($db, QueryUpdate('Contestants', ['id'=>$ContestantId], ['name'=>$name, 'surname'=>$surname]));
	return ['type'=>'good', 'text'=>'Nome e cognome del partecipante sono stati modificati con successo', 'data'=>[
		'ContestantId'=>$ContestantId, 'name'=>$name, 'surname'=>$surname
	]];
}

function ChangeSchool($db, $ContestantId, $school) {
	$Exist1 = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$ContestantId]));
	if (is_null($Exist1)) {
		return ['type'=>'bad', 'text'=>'Il partecipante selezionato non esiste'];
	}
	
	if (!is_string($school) or strlen($school) > ContestantSchool_MAXLength) {
		return ['type'=>'bad', 'text'=>'La scuola deve essere una stringa di al più '.ContestantSchool_MAXLength.' caratteri'];
	}

	Query($db, QueryUpdate('Contestants', ['id'=>$ContestantId], ['school'=>$school]));
	return ['type'=>'good', 'text'=>'La scuola del partecipante è stata modificata con successo'];
}

function ChangeSchoolCity($db, $ContestantId, $SchoolCity) {
	$Exist1 = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$ContestantId]));
	if (is_null($Exist1)) {
		return ['type'=>'bad', 'text'=>'Il partecipante selezionato non esiste'];
	}
	
	if (!is_string($SchoolCity) or strlen($SchoolCity) > ContestantSchoolCity_MAXLength) {
		return ['type'=>'bad', 'text'=>'La città della scuola deve essere una stringa di al più '.ContestantSchoolCity_MAXLength.' caratteri'];
	}

	Query($db, QueryUpdate('Contestants', ['id'=>$ContestantId], ['SchoolCity'=>$SchoolCity]));
	return ['type'=>'good', 'text'=>'La città della scuola del partecipante è stata modificata con successo'];
}

function ChangeEmail($db, $ContestantId, $email) {
	$Exist1 = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$ContestantId]));
	if (is_null($Exist1)) {
		return ['type'=>'bad', 'text'=>'Il partecipante selezionato non esiste'];
	}
	
	if (!is_string($email) or strlen($email) > ContestantEmail_MAXLength) {
		return ['type'=>'bad', 'text'=>'L\'email deve essere una stringa di al più '.ContestantEmail_MAXLength.' caratteri'];
	}

	Query($db, QueryUpdate('Contestants', ['id'=>$ContestantId], ['email'=>$email]));
	return ['type'=>'good', 'text'=>'L\'email del partecipante è stata modificata con successo'];
}

function ChangeLastOlympicYear($db, $ContestantId, $LastOlympicYear) {
	$LastOlympicYear = intval($LastOlympicYear);
	$Exist1 = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$ContestantId]));
	if (is_null($Exist1)) {
		return ['type'=>'bad', 'text'=>'Il partecipante selezionato non esiste'];
	}

	Query($db, QueryUpdate('Contestants', ['id'=>$ContestantId], ['LastOlympicYear'=>$LastOlympicYear]));
	return ['type'=>'good', 'text'=>'L\'ultimo anno olimpico del partecipante è stato modificato con successo'];	
}

$db= OpenDbConnection();
if (IsAdmin($db, GetUserIdBySession()) == 0) {
	$db -> close();
	SendObject(['type'=>'bad', 'text'=>'Non hai i permessi per gestire i partecipanti']);
	die();
}

$data = json_decode($_POST['data'], 1);
if ($data['type'] == 'add') SendObject(AddContestant($db, $data['name'], $data['surname'], $data['school'], $data['SchoolCity'], $data['email'], $data['LastOlympicYear']));
else if ($data['type'] == 'remove') SendObject(RemoveContestant($db, $data['ContestantId']));
else if ($data['type'] == 'AddParticipation') {
	if (isset($_FILES['solutions'])) SendObject(AddParticipation($db, $data['ContestantId'], $data['ContestId'], $_FILES['solutions']));
	else SendObject(AddParticipation($db, $data['ContestantId'], $data['ContestId'], null));
}
else if ($data['type'] == 'RemoveParticipation') SendObject(RemoveParticipation($db, $data['ContestantId'], $data['ContestId']));
else if ($data['type'] == 'ChangeNameAndSurname') SendObject(ChangeNameAndSurname($db, $data['ContestantId'], $data['name'], $data['surname']));
else if ($data['type'] == 'ChangeSchool') SendObject(ChangeSchool($db, $data['ContestantId'], $data['school']));
else if ($data['type'] == 'ChangeSchoolCity') SendObject(ChangeSchoolCity($db, $data['ContestantId'], $data['SchoolCity']));
else if ($data['type'] == 'ChangeEmail') SendObject(ChangeEmail($db, $data['ContestantId'], $data['email']));
else if ($data['type'] == 'ChangeLastOlympicYear') SendObject(ChangeLastOlympicYear($db, $data['ContestantId'], $data['LastOlympicYear']));
else SendObject(['type'=>'bad', 'text'=>'L\'azione scelta non esiste']);


$db -> close();
?>
