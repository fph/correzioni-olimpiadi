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
	header('Content-Disposition:attachment;filename=\'cognomepulito.pdf\'');
	echo $PdfFile;
}


function GetContestZip($db, $ContestId) {
	$contest = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	$ZipName = UploadDirectory.$contest['SolutionsZip'].'.zip';
	$ZipFile = file_get_contents($ZipName);
	
	header('Content-type: application/octet-stream');
	header("Content-Length: ".filesize($ZipName) );
	header('Content-Disposition:attachment;filename=\'garapulita.zip\'');
	echo $ZipFile;
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
