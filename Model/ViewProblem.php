<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General","AskInformation.php");
	SuperRequire_once("General", "TemplateCreation.php");
	
	$problemId=$_GET["problemId"];
	
	$db=OpenDbConnection();
	
	$v_problem=OneResultQuery($db, QuerySelect('Problems', ['id'=>$problemId]));
	$v_contest=OneResultQuery($db, QuerySelect('Contests', ['id'=>$v_problem['ContestId']]));
	$v_corrections=ManyResultQuery($db, QuerySelect('Corrections', ['ProblemId'=>$problemId]));
	
	foreach($v_corrections as &$cor) {
		$cor['contestant']=OneResultQuery($db, QuerySelect('Contestants', ['id'=>$cor['ContestantId']]));
		$cor['surname']=$cor['contestant']['surname'];
		$cor['username']=OneResultQuery($db, QuerySelect('Users', ['id'=>$cor['UserId']], ['username']))['username'];
	}
	
	usort($v_corrections, build_sorter('surname'));
	
	$db->close();
	
	TemplatePage("ViewProblem",['Index'=>'index.php',
								'Gare'=>'ViewContests.php',
								$v_contest['name']=>'ViewContestInformation.php?contestId='.$v_contest['id'],
								'Problemi'=>'ViewProblemsOfAContest.php?contestId='.$v_contest['id'],
								$v_problem['name']=>'ViewProblem.php?problemId='.$problemId]);
?>
