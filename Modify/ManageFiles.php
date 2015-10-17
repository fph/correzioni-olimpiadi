<?php
require_once '../Utilities.php';
SuperRequire_once('General', 'sqlUtilities.php');
SuperRequire_once('General', 'PermissionManager.php');

function GetParticipationFile($db, $ParticipationId) {
	$participation = OneResultQuery($db, QuerySelect('Participations', ['id'=>$ParticipationId]));
	$PdfName = UploadDirectory.$participation['solutions'].'.pdf';
	$PdfFile = file_get_contents($PdfName);
	
	header('Content-type: application/pdf');
	header('Content-Length: '.filesize($PdfName));
	$contestant = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$participation['ContestantId']]));
	$CleanedSurname = preg_replace('/[^\p{L}]/u', '', $contestant['surname']);
	header('Content-Disposition:attachment;filename=\''.$CleanedSurname.'.pdf\'');
	echo $PdfFile;
}


function GetContestZip($db, $ContestId) {
	$contest = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	$ZipName = UploadDirectory.$contest['SolutionsZip'].'.zip';
	$ZipFile = file_get_contents($ZipName);
	
	header('Content-type: application/octet-stream');
	header('Content-Length: '.filesize($ZipName) );
	$CleanedContest = preg_replace('/[^\p{L}0-9\-]/u', '', $contest['name']);
	header('Content-Disposition:attachment;filename=\''.$CleanedContest.'.zip\'');
	echo $ZipFile;
}

function CreateContestZip($db, $ContestId) {
	$contest = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	
	// Generate filename
	if (is_null($contest['SolutionsZip'])) {
		$ZipName = GenerateRandomString();	
		while (file_exists(UploadDirectory.$ZipName.'.zip')) $ZipName = GenerateRandomString();
		Query($db, QueryUpdate('Contests', ['id'=>$ContestId], ['SolutionsZip'=>$ZipName]));
		$contest['SolutionsZip'] = $ZipName;
	}
	
	$zip = new ZipArchive;
	$zip->open(UploadDirectory.$contest['SolutionsZip'].'.zip', ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
	
	$AllParticipations = ManyResultsQuery($db, QuerySelect('Participations', ['ContestId'=>$ContestId]));
	foreach ($AllParticipations as $participation) {
		if (!is_null($participation['solutions'])) {
			$contestant = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$participation['ContestantId']]));
			$CleanedSurname = preg_replace('/[^\p{L}]/u', '', $contestant['surname']);
			$zip->addFile(UploadDirectory.$participation['solutions'].'.pdf', $CleanedSurname.'.pdf');
		}
	}
	
	$zip->close();
}


// FIXME: Dovrei verificare un mare di cose
$db = OpenDbConnection();
$ContestId = $_GET['ContestId'];

if (VerifyPermission($db, GetUserIdBySession(), $ContestId) {
	$type = $_GET['type'];
	if ($type === 'ContestZip') GetContestZip($db, $ContestId);
	else if ($type === 'ParticipationFile') GetParticipationFile($db, $_GET['ParticipationId']);
}

$db->close();
