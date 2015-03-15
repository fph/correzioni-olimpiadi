<?php
	//~ $start_time = microtime(true);
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	$ContestId=$_GET['ContestId'];
	
	CheckPagePermission($db,$ContestId);
	
	//PermissionChecked	
	
	$v_admin=0;
	if (IsAdmin($db,getUserIdBySession())) $v_admin=1;
	else $v_admin=0;
	
	$v_contest=OneResultQuery($db, QuerySelect('Contests',['id'=>$ContestId]));
	$v_problems=ManyResultQuery($db, QuerySelect('Problems',['ContestId'=>$ContestId]));
	$participations=ManyResultQuery($db, QuerySelect('Participations',['ContestId'=>$ContestId],['ContestantId']));
	$v_contestants=[];
	foreach($participations as $X) {
		$contestant=OneResultQuery($db, QuerySelect('Contestants',['id'=>$X['ContestantId']]));
		$contestant['marks']=[];
		$v_contestants[$X['ContestantId']]=$contestant;
	}
	foreach($v_problems as $problem) {
		$ProblemCorrections=ManyResultQuery($db, QuerySelect('Corrections',['ProblemId'=>$problem['id']]));
		foreach($ProblemCorrections as $correction) {
			$v_contestants[$correction['ContestantId']]['marks'][$correction['ProblemId']]=$correction['mark'];
		}
	}
	
	
	$db->close();
	
	TemplatePage('ViewRankingOfAContest', [	'Index'=>'index.php',
											'Gare'=>'ViewContests.php',
											$v_contest['name']=>'ViewContestInformation.php?ContestId='.$ContestId,
											'Classifica'=>'ViewRankingOfAContest.php?ContestId='.$ContestId]);
	//~ echo(number_format(microtime(true) - $start_time, 5));
?>
