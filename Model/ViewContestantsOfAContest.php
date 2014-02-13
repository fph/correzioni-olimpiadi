<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General","AskInformation.php");
	SuperRequire_once("General", "TemplateCreation.php");
	
	$contestId=$_GET["contestId"]; 
	
	$db=OpenDbConnection();
	
	$v_contest=OneResultQuery($db, QuerySelect('Contests', ['id'=>$contestId]));
	
	$v_contestants=ManyResultQuery($db, QuerySelect('Participations', ['ContestId'=>$contestId]));
	
	foreach($v_contestants as &$con){
		$con=OneResultQuery($db, QuerySelect('Contestants', ['id'=>$con['ContestantId']]));
	}
	
	usort($v_contestants, build_sorter('surname'));
	
	
	
	$db->close();
	
	TemplatePage("ViewContestantsOfAContest",[	'Index'=>'index.php',
												'Gare'=>'ViewContests.php',
												$v_contest['name']=>'ViewContestInformation.php?contestId='.$contestId,
												'Partecipanti'=>'ViewContestantsOfAContest.php?contestId='.$contestId]);
?>
