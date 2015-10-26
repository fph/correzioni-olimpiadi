<?php
	
	require_once '../Utilities.php';
	SuperRequire_once('General', 'sqlUtilities.php');
	SuperRequire_once('General', 'TemplateCreation.php');
	SuperRequire_once('General', 'PermissionManager.php');
	
	$db = OpenDbConnection();
	
	$ContestId = $_GET['ContestId'];
	$ContestantId = $_GET['ContestantId'];
	
	CheckPagePermission($db, $ContestId);
	
	//PermissionChecked
	
	$participation = OneResultQuery($db, QuerySelect('Participations', ['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]));
	$v_MailSent = $participation['email'];
	$v_SolutionsBoolean = !is_null($participation['solutions']);
	
	
	$v_admin = 0;
	if (IsAdmin($db, getUserIdBySession())) $v_admin = 1;
	else $v_admin = 0;

	$v_contest = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	$v_contestant = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$ContestantId]));
	
	$problems = ManyResultQuery($db, QuerySelect('Problems', ['ContestId'=>$ContestId]));
	
	$v_corrections = [];
	
	foreach ($problems as $problem) {
		$correction = OneResultQuery($db, QuerySelect('Corrections', 
		['ProblemId'=>$problem['id'], 'ContestantId'=>$ContestantId], 
		['mark', 'comment', 'UserId']
		));
		
		if (is_null($correction)) {
			// UserId is defined only to have the same object structure in both cases.
			$correction['mark'] = $correction['UserId'] = $correction['username'] = null; 
			$correction['comment'] = '';
		}
		else {
			$correction['username'] = OneResultQuery($db, QuerySelect('Users', ['id'=>$correction['UserId']], ['username']))['username'];
		}
		$correction['problem'] = OneResultQuery($db, QuerySelect('Problems', ['id'=>$problem['id']]));
		
		$v_corrections[]= $correction;
	}
	
	
	
	$db->close();
	
	TemplatePage('ViewParticipation', [	'Index'=>'index.php',
										'Gare'=>'ViewContests.php',
										$v_contest['name']=>'ViewContestInformation.php?ContestId='.$ContestId,
										'Partecipanti'=>'ViewContestantsOfAContest.php?ContestId='.$ContestId,
										$v_contestant['name'].' '.$v_contestant['surname']=>'ViewParticipation.php?ContestId='.$ContestId.'&amp; ContestantId='.$ContestantId]);
?>
