<?php
	
	require_once '../Utilities.php';
	SuperRequire_once('General', 'sqlUtilities.php');
	SuperRequire_once('General', 'TemplateCreation.php');
	SuperRequire_once('General', 'PermissionManager.php');
	
	$db = OpenDbConnection();
	
	CheckPagePermission($db, -1);
	
	//PermissionChecked	
	
	$ContestantId = $_GET['ContestantId'];
	
	$v_contestant=OneResultQuery($db, QuerySelect('Contestants', ['id'=>$ContestantId]));
	
	$v_contests=ManyResultQuery($db, QuerySelect('Participations', ['ContestantId'=>$ContestantId]));
	
	foreach ($v_contests as &$con) {
		$con = OneResultQuery($db, QuerySelect('Contests', ['id'=>$con['ContestId']]));
	}
	
	$db->close();
	
	TemplatePage('AdminContestantInformation', [	'Index'=>'index.php',
												'Amministrazione'=>'AdminAdministration.php',
												'Partecipanti'=>'AdminContestants.php',
												$v_contestant['surname'].' '.$v_contestant['name']=>'AdminContestantInformation.php?ContestantId='.$ContestantId]);
?>
