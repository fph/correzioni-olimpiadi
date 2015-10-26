<?php
require_once '../Utilities.php';
SuperRequire_once('General', 'sqlUtilities.php');
SuperRequire_once('General', 'PermissionManager.php');

function GetParticipationPdf($db, $ContestId, $ContestantId) {
	$participation = OneResultQuery($db, QuerySelect('Participations', ['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]));
	
	if (is_null($participation) or is_null($participation['solutions'])) return;
	
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
	
	if (is_null($contest['SolutionsZip'])) return;
	
	$ZipName = UploadDirectory.$contest['SolutionsZip'].'.zip';
	$ZipFile = file_get_contents($ZipName);
	
	header('Content-type: application/octet-stream');
	header('Content-Length: '.filesize($ZipName) );
	$CleanedContest = preg_replace('/[^\p{L}0-9\-]/u', '', $contest['name']);
	header('Content-Disposition:attachment;filename=\''.$CleanedContest.'.zip\'');
	echo $ZipFile;
}

$db = OpenDbConnection();
$ContestId = $_GET['ContestId'];

if (VerifyPermission($db, GetUserIdBySession(), $ContestId)) {
	$type = $_GET['type'];
	if ($type === 'ContestZip') GetContestZip($db, $ContestId);
	else if ($type === 'ParticipationPdf') GetParticipationPdf($db, $_GET['ContestId'], $_GET['ContestantId']);
}

$db->close();
