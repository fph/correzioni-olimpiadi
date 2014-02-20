<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	$ProblemId=$_GET['ProblemId'];
	$v_problem=OneResultQuery($db, QuerySelect('Problems', ['id'=>$ProblemId]));
	$v_contest=OneResultQuery($db, QuerySelect('Contests', ['id'=>$v_problem['ContestId']]));
	
	CheckPagePermission($db,$v_contest['id']);
	
	//Permission checked
	
	$contestants=ManyResultQuery($db, QuerySelect('Participations', ['ContestId'=>$v_contest['id']]));
	
	$v_corrections=[];
	
	foreach ($contestants as $con) {
		$nn=OneResultQuery($db, QuerySelect('Corrections', ['ProblemId'=>$ProblemId, 'ContestantId'=>$con['ContestantId']]));
		if (!is_null($nn)) $nn['done']=true;
		else $nn['done']=false;
		$nn['contestant']=OneResultQuery($db, QuerySelect('Contestants', ['id'=>$con['ContestantId']]));
		$nn['surname']=$nn['contestant']['surname'];
		$nn['username']=OneResultQuery($db, QuerySelect('Users', ['id'=>$nn['UserId']], ['username']))['username'];
		$v_corrections[]=$nn;
	}
	
	usort($v_corrections, build_sorter('surname'));
	
	$db->close();
	
	TemplatePage("ViewProblem",['Index'=>'index.php',
								'Gare'=>'ViewContests.php',
								$v_contest['name']=>'ViewContestInformation.php?ContestId='.$v_contest['id'],
								'Problemi'=>'ViewProblemsOfAContest.php?ContestId='.$v_contest['id'],
								$v_problem['name']=>'ViewProblem.php?ProblemId='.$ProblemId]);
?>
