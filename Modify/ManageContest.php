<?php
require_once '../Utilities.php';
SuperRequire_once('General', 'SessionManager.php');
SuperRequire_once('General', 'sqlUtilities.php');
SuperRequire_once('General', 'PermissionManager.php');
SuperRequire_once('Modify', 'ObjectSender.php');
	
function ValidateDate($date) {
	if (!is_string($date)) return false;
	$d = DateTime::createFromFormat('Y-m-d', $date);
	if ($d == null or $d->format('Y-m-d') != $date) return false;
	if (intval($d->format('Y'))<2000 or 2020<intval($d->format('Y'))) return false;
	return true;
}
	
function AddContest($db, $name, $date) {
	if (!is_string($name) or strlen($name) <= ContestName_MINLength or strlen($name)>ContestName_MAXLength) {
		return ['type'=>'bad', 'text'=>'Il nome della gara deve essere una stringa con un numero di caratteri compreso tra '.ContestName_MINLength.' e '.ContestName_MAXLength];
	}
	
	if (!ValidateDate($date)) {
		return ['type'=>'bad', 'text'=>'La data deve essere ben formata e riferirsi ad un giorno nell\'arco di tempo tra il 2000 e il 2020'];
	}
	
	Query($db, QueryInsert('Contests', ['name'=>$name, 'date'=>$date, 'blocked'=>0, 'NotAcceptedEmail'=>'']));
	return ['type'=>'good', 'text'=>'La gara è stata creata con successo', 'data'=>[
	'ContestId'=>$db->insert_id, 'name'=>$name, 'date'=>$date] ];
}

function RemoveContest($db, $ContestId) {
	$Exist1 = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	if (is_null($Exist1)) {
		return ['type'=>'bad', 'text'=>'La gara scelta non esiste'];
	}
	
	Query($db, QueryDelete('Contests', ['id'=>$ContestId]));
	// TODO: Should delete all corrections, all remaining files and so on (should call RemoveParticipation)
	
	return ['type'=>'good', 'text'=>'La gara è stata eliminata con successo', 'ContestId'=>$ContestId];
}

function BlockContest($db, $ContestId) {
	$Exist1 = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	if (is_null($Exist1)) {
		return ['type'=>'bad', 'text'=>'La gara scelta non esiste'];
	}
	if ($Exist1['blocked'] == 1) {
		return ['type'=>'bad', 'text'=>'La gara scelta è già bloccata'];
	}
	
	Query($db, QueryUpdate('Contests', ['id'=>$ContestId], ['blocked'=>1]));
	return ['type'=>'good', 'text'=>'La gara è stata bloccata con successo'];
}

function UnblockContest($db, $ContestId) {
	$Exist1 = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	if (is_null($Exist1)) {
		return ['type'=>'bad', 'text'=>'La gara scelta non esiste'];
	}
	if ($Exist1['blocked'] == 0) {
		return ['type'=>'bad', 'text'=>'La gara scelta non è bloccata'];
	}
	
	Query($db, QueryUpdate('Contests', ['id'=>$ContestId], ['blocked'=>0]));
	return ['type'=>'good', 'text'=>'La gara è stata sbloccata con successo'];
}

function CreateZip($db, $ContestId) {
	$contest = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	
	if (is_null($contest)) {
		return ['type'=>'bad', 'text'=>'La gara scelta non esiste'];
	}
	
	$AllParticipations = ManyResultQuery($db, QuerySelect('Participations', ['ContestId'=>$ContestId]));
	
	// Checking whether the is at least one pdf (because otherwise ZipArchive doesn't create the zip file)
	$NoPdf = true;
	foreach ($AllParticipations as $participation) {
		if (!is_null($participation['solutions'])) {
			$NoPdf = false;
			break;
		}
	}
	if ($NoPdf === true) {
		return  ['type'=>'bad', 'text'=>'Non è presente neanche un elaborato'];
	}
	
	// Generate filename
	if (is_null($contest['SolutionsZip'])) {
		$ZipName = GenerateRandomString();	
		while (file_exists(UploadDirectory.$ZipName.'.zip')) $ZipName = GenerateRandomString();
		Query($db, QueryUpdate('Contests', ['id'=>$ContestId], ['SolutionsZip'=>$ZipName]));
		$contest['SolutionsZip'] = $ZipName;
	}
	
	$zip = new ZipArchive;
	$zip->open(UploadDirectory.$contest['SolutionsZip'].'.zip', ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
	
	foreach ($AllParticipations as $participation) {
		if (!is_null($participation['solutions'])) {
			$contestant = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$participation['ContestantId']]));
			$CleanedSurname = preg_replace('/[^\p{L}]/u', '', $contestant['surname']);
			
			// Dealing with homonyms
			if ($zip->locateName($CleanedSurname.'.pdf') !== false) {
				$i = 2;
				while ($zip->locateName($CleanedSurname.strval($i).'.pdf') !== false) $i++;
				$CleanedSurname .= strval($i);
			}
			$zip->addFile(UploadDirectory.$participation['solutions'].'.pdf', $CleanedSurname.'.pdf');
		}
	}
	
	$zip->close();
	
	return ['type'=>'good', 'text'=>'Il file zip è stato generato con successo'];
}

function ChangeName($db, $ContestId, $name) {
	if (!is_string($name) or strlen($name) <= ContestName_MINLength or strlen($name)>ContestName_MAXLength) {
		return ['type'=>'bad', 'text'=>'Il nome della gara deve essere una stringa con un numero di caratteri compreso tra '.ContestName_MINLength.' e '.ContestName_MAXLength];
	}
	
	$Exist1 = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	if (is_null($Exist1)) {
		return ['type'=>'bad', 'text'=>'La gara scelta non esiste'];
	}
	
	Query($db, QueryUpdate('Contests', ['id'=>$ContestId], ['name'=>$name]));
	return ['type'=>'good', 'text'=>'Il nome è stato cambiato con successo'];
}

function ChangeDate($db, $ContestId, $date) {
	if (!ValidateDate($date)) {
		return ['type'=>'bad', 'text'=>'La data deve essere ben formata e riferirsi ad un giorno nell\'arco di tempo tra il 2000 e il 2020'];
	}
	
	$Exist1 = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	if (is_null($Exist1)) {
		return ['type'=>'bad', 'text'=>'La gara scelta non esiste'];
	}
	
	Query($db, QueryUpdate('Contests', ['id'=>$ContestId], ['date'=>$date]));
	return ['type'=>'good', 'text'=>'La data è stata cambiata con successo'];
}

function ChangeNameAndDate($db, $ContestId, $name, $date) {
	if (!is_string($name) or strlen($name) <= ContestName_MINLength or strlen($name) > ContestName_MAXLength) {
		return ['type'=>'bad', 'text'=>'Il nome della gara deve essere una stringa con un numero di caratteri compreso tra '.ContestName_MINLength.' e '.ContestName_MAXLength];
	}
	
	if (!ValidateDate($date)) {
		return ['type'=>'bad', 'text'=>'La data deve essere ben formata e riferirsi ad un giorno nell\'arco di tempo tra il 2000 e il 2020'];
	}
	
	$Exist1 = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	if (is_null($Exist1)) {
		return ['type'=>'bad', 'text'=>'La gara scelta non esiste'];
	}
	
	Query($db, QueryUpdate('Contests', ['id'=>$ContestId], ['name'=>$name, 'date'=>$date]));
	return ['type'=>'good', 'text'=>'Il nome e la data sono stati cambiati con successo'];
}

function ChangeNotAcceptedEmail($db, $ContestId, $NotAcceptedEmail) {
	if (!is_string($NotAcceptedEmail) or strlen($NotAcceptedEmail) > ContestNotAcceptedEmail_MAXLength) {
		return ['type'=>'bad', 'text'=>'Il paragrafo della mail per i segati deve essere una stringa con al più '.ContestNotAcceptedEmail_MAXLength.' caratteri'];
	}
	$Exist1 = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	if (is_null($Exist1)) {
		return ['type'=>'bad', 'text'=>'La gara scelta non esiste'];
	}

	Query($db, QueryUpdate('Contests', ['id'=>$ContestId], ['NotAcceptedEmail'=>$NotAcceptedEmail]));
	return ['type'=>'good', 'text'=>'Il paragrafo della mai per i segati è stato cambiato con successo'];
}

function AddProblem($db, $ContestId, $name) {
	if (!is_string($name) or strlen($name) > ProblemName_MAXLength or strlen($name) == 0) {
		return ['type'=>'bad', 'text'=>'Il nome del problema deve essere una stringa non vuota di al più '.ProblemName_MAXLength.' caratteri'];
	}
	
	$Exist1 = OneResultQuery($db, QuerySelect('Problems', ['ContestId'=>$ContestId, 'name'=>$name]));
	if (!is_null($Exist1)) {
		return ['type'=>'bad', 'text'=>'La gara scelta ha già un problema con lo stesso nome'];
	}
	
	Query($db, QueryInsert('Problems', ['ContestId'=>$ContestId, 'name'=>$name]));
	return ['type'=>'good', 'text'=>'Il problema è stato aggiunto con successo', 'data'=>[
		'ProblemId'=>$db->insert_id, 'ProblemName'=>$name
	]];
}

function RemoveProblem($db, $ProblemId) {
	$Exist1 = OneResultQuery($db, QuerySelect('Problems', ['id'=>$ProblemId]));
	if (is_null($Exist1)) {
		return ['type'=>'bad', 'text'=>'Il problema non esiste'];
	}
	
	Query($db, QueryDelete('Problems', ['id'=>$ProblemId]));
	return ['type'=>'good', 'text'=>'Il problema è stato eliminato con successo', 'ProblemId'=>$ProblemId];
}

function ChangeProblemName($db, $ProblemId, $name) {
	if (!is_string($name) or strlen($name)>ProblemName_MAXLength or strlen($name) == 0) {
		return ['type'=>'bad', 'text'=>'Il nome del problema deve essere una stringa non vuota di al più '.ProblemName_MAXLength.' caratteri'];
	}
	
	$Problem = OneResultQuery($db, QuerySelect('Problems', ['id'=>$ProblemId]));
	if (is_null($Problem)) {
		return ['type'=>'bad', 'text'=>'Il problema non esiste'];
	}
	
	$ContestId = $Problem['ContestId'];
	
	$Exist1 = OneResultQuery($db, QuerySelect('Problems', ['ContestId'=>$ContestId, 'name'=>$name]));
	if (!is_null($Exist1)) {
		return ['type'=>'bad', 'text'=>'La gara scelta ha già un problema con questo nome'];
	}
	
	Query($db, QueryUpdate('Problems', ['id'=>$ProblemId], ['name'=>$name]));
	return ['type'=>'good', 'text'=>'Il nome del problema è stato cambiato con successo'];
}

	
	
$db= OpenDbConnection();
if (IsAdmin($db, GetUserIdBySession()) == 0) {
	$db -> close();
	SendObject(['type'=>'bad', 'text'=>'Non hai i permessi per gestire le gare o i problemi']);
	die();
}

$data = json_decode($_POST['data'], 1);
if ($data['type'] == 'add') SendObject(AddContest($db, $data['name'], $data['date']));
else if ($data['type'] == 'remove') SendObject(RemoveContest($db, $data['ContestId']));
else if ($data['type'] == 'block') SendObject(BlockContest($db, $data['ContestId']));
else if ($data['type'] == 'unblock') SendObject(UnblockContest($db, $data['ContestId']));
else if ($data['type'] == 'CreateZip') SendObject(CreateZip($db, $data['ContestId']));
else if ($data['type'] == 'ChangeName') SendObject(ChangeName($db, $data['ContestId'], $data['name']));
else if ($data['type'] == 'ChangeDate') SendObject(ChangeDate($db, $data['ContestId'], $data['date']));
else if ($data['type'] == 'ChangeNameAndDate') SendObject(ChangeNameAndDate($db, $data['ContestId'], $data['name'], $data['date']));
else if ($data['type'] == 'ChangeNotAcceptedEmail') SendObject(ChangeNotAcceptedEmail($db, $data['ContestId'], $data['NotAcceptedEmail']));
else if ($data['type'] == 'AddProblem') SendObject(AddProblem($db, $data['ContestId'], $data['name']));
else if ($data['type'] == 'RemoveProblem') SendObject(RemoveProblem($db, $data['ProblemId']));
else if ($data['type'] == 'ChangeProblemName') SendObject(ChangeProblemName($db, $data['ProblemId'], $data['name']));
else SendObject(['type'=>'bad', 'text'=>'L\'azione scelta non esiste']);

$db -> close();
?>
