<?php	
	require_once '../Utilities.php';
	SuperRequire_once('General', 'sqlUtilities.php');
	SuperRequire_once('General', 'TemplateCreation.php');
	SuperRequire_once('General', 'PermissionManager.php');
	
	$db = OpenDbConnection();
	
	$ContestId = $_GET['ContestId'];
	
	CheckPagePermission($db, $ContestId);
	
	//PermissionChecked	
	
	$v_contest=OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	
	$v_contestants=ManyResultSafeQuery($db, 
		'SELECT * FROM Participations JOIN Contestants ON ContestantId=Contestants.id WHERE ContestId=?',
		'i', $ContestId
	);
	
	$db->close();
	
	TemplatePage('ViewContestantsOfAContest', [	'Index'=>'index.php',
												'Gare'=>'ViewContests.php',
												$v_contest['name']=>'ViewContestInformation.php?ContestId='.$ContestId,
												'Partecipanti'=>'ViewContestantsOfAContest.php?ContestId='.$ContestId]);
?>
