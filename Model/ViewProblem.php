<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	$problemId=$_GET["problemId"];
	$v_problem=OneResultQuery($db, QuerySelect('Problems', ['id'=>$problemId]));
	$v_contest=OneResultQuery($db, QuerySelect('Contests', ['id'=>$v_problem['ContestId']]));
	
	CheckPagePermission($db,$v_contest['id']);
	
	//Permission checked
	
	$contestants=ManyResultQuery($db, QuerySelect('Participations', ['ContestId'=>$v_contest['id']]));
	
	$v_corrections=[];
	
	foreach ($contestants as $con) {
		$newCor=OneResultQuery($db, QuerySelect('Corrections', ['ProblemId'=>$problemId, 'ContestantId'=>$con['ContestantId']]));
		if (!is_null($newCor)) $newCor['done']=true;
		else $newCor['done']=false;
		$newCor['contestant']=OneResultQuery($db, QuerySelect('Contestants', ['id'=>$con['ContestantId']]));
		$newCor['surname']=$newCor['contestant']['surname'];
		$newCor['username']=OneResultQuery($db, QuerySelect('Users', ['id'=>$newCor['UserId']], ['username']))['username'];
		$v_corrections[]=$newCor;
	}
	
	usort($v_corrections, build_sorter('surname'));
	
	$db->close();
	
	TemplatePage("ViewProblem",['Index'=>'index.php',
								'Gare'=>'ViewContests.php',
								$v_contest['name']=>'ViewContestInformation.php?contestId='.$v_contest['id'],
								'Problemi'=>'ViewProblemsOfAContest.php?contestId='.$v_contest['id'],
								$v_problem['name']=>'ViewProblem.php?problemId='.$problemId]);
?>
