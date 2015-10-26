<?php
	
	require_once '../Utilities.php';
	SuperRequire_once('General', 'sqlUtilities.php');
	SuperRequire_once('General', 'TemplateCreation.php');
	SuperRequire_once('General', 'PermissionManager.php');
	
	$db = OpenDbConnection();
	
	CheckPagePermission($db, -1);
	
	//PermissionChecked
	
	$ContestId = $_GET['ContestId'];
	
	$v_contest=OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	
	$participations=ManyResultQuery($db, QuerySelect('Participations', ['ContestId'=>$ContestId]));
	
	$v_contestants = [];
	foreach ($participations as $participation) {
		$contestant = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$participation['ContestantId']]));
		$contestant['SolutionsBoolean'] = is_null($participation['solutions'])?0:1;
		$v_contestants []= $contestant;
	}
	
	$db->close();
	
	TemplatePage('AdminContestantsOfAContest', [	'Index'=>'index.php',
												'Amministrazione'=>'AdminAdministration.php',
												'Gare'=>'AdminContests.php',
												$v_contest['name']=>'AdminContestInformation.php?ContestId='.$ContestId,
												'Partecipanti'=>'AdminContestantsOfAContest.php?ContestId='.$ContestId]);
?>
