<?php
require_once '../Utilities.php';
SuperRequire_once('General', 'sqlUtilities.php');
SuperRequire_once('Modify', 'ObjectSender.php');

function CreateContestant($db, $name, $surname, $school, $email, $SchoolYear, $OldUser) {
	// Length validation
	if (!is_string($name) or strlen($name) > ContestantName_MAXLength or strlen($name) == 0) {
		return ['type'=>'bad', 'text'=>'Il nome deve essere una stringa di al più '.ContestantName_MAXLength.' caratteri'];
	}
	
	if (!is_string($surname) or strlen($surname) > ContestantSurname_MAXLength or strlen($surname) == 0) {
		return ['type'=>'bad', 'text'=>'Il cognome deve essere una stringa di al più '.ContestantSurname_MAXLength.' caratteri'];
	}
	
	if (!is_string($school) or strlen($school) > ContestantSchool_MAXLength or strlen($school) <= 2) {
		return ['type'=>'bad', 'text'=>'La scuola deve essere una stringa di al più '.ContestantSchool_MAXLength.' caratteri'];
	}
	
	if (!is_string($email) or strlen($email) > ContestantEmail_MAXLength or strlen($email) < 5) {
		return ['type'=>'bad', 'text'=>'L\'email deve essere una stringa di al più '.ContestantEmail_MAXLength.' caratteri'];
	}
	
	// Characters validation
	if (!preg_match("/^[\p{L} '\-]+$/u", $name)) {
		return ['type'=>'bad', 'text'=>'Il nome può contenere solo lettere, apostrofi e \'-\''];
	}
	
	if (!preg_match("/^[\p{L} '\-]+$/u", $surname)) {
		return ['type'=>'bad', 'text'=>'Il cognome può contenere solo lettere, apostrofi e \'-\''];
	}
	
	if (!preg_match("/^[\p{L} '\-\.,0-9]+$/u", $school)) {
		return ['type'=>'bad', 'text'=>'Il nome della scuola può contenere solo lettere, numeri, apostrofi e \'-\''];
	}
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return ['type'=>'bad', 'text'=>'L\'email non è in un formato corretto'];
	}
	
	// intval return 0 if $SchoolYear is not representing a number
	$SchoolYear = intval($SchoolYear);
	if ($SchoolYear < 1 or 5 < $SchoolYear) {
		return ['type'=>'bad', 'text'=>'L\'anno di corso deve essere un numero tra 1 e 5'];
	}

	// Calculation of LastOlympicYear given SchoolYear
	$NowTime = new Datetime('now');
	$CurrentYear = intval($NowTime->format('Y'));
	$CurrentMonth = intval($NowTime->format('m'));
	$LastOlympicYear = $CurrentYear + (5 - $SchoolYear) + (($CurrentMonth >= 6)?1:0);

	$row = OneResultQuery($db, QuerySelect('Contestants', ['email'=>$email]));
	if ($OldUser) {
		if (is_null($row)) {
			return ['type'=>'bad', 'text'=>'Nessun partecipante registrato ha tale email'];
		}
		$ContestantId = $row['id'];
		Query($db, QueryUpdate('Contestants', ['id'=>$ContestantId], [
			'name'=>$name,
			'surname'=>$surname, 
			'school'=>$school, 
			'email'=>$email,
			'LastOlympicYear'=>$LastOlympicYear
		]));
		
		return ['type'=>'good', 'text'=>'I tuoi dati sono stati registrati', 'data'=>['ContestantId'=>$ContestantId]];
	}
	else {
		if (!is_null($row)) {
			return ['type'=>'bad', 'text'=>'L\'email risulta già usata sul sito'];
		}
		Query($db, QueryInsert('Contestants', [
			'name'=>$name,
			'surname'=>$surname, 
			'school'=>$school, 
			'email'=>$email,
			'LastOlympicYear'=>$LastOlympicYear
		]));
		
		return ['type'=>'good', 'text'=>'I tuoi dati sono stati registrati', 'data'=>['ContestantId'=>$db->insert_id]];
	}
}

$db = OpenDbConnection();
$data = json_decode($_POST['data'], 1);

// Checking verification code
$row = OneResultQuery($db, QuerySelect('VerificationCodes', ['email'=>$data['email'], 'code'=>$data['code']]));
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
SendObject(CreateContestant($db, $data['name'], $data['surname'], $data['school'], $data['email'], $data['SchoolYear'], $data['OldUser']));

$db->close();
?>
