<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General","AskInformation.php");
	SuperRequire_once("General", "TemplateCreation.php");
	
	$contestId=$_GET["contestId"];
	$contestantId=$_GET["contestantId"];
	
	$db=OpenDbConnection();
	
	$v_contest=OneResultQuery($db, QuerySelect('Contests', ['id'=>$contestId]));
	$v_contestant=OneResultQuery($db, QuerySelect('Contestants', ['id'=>$contestantId]));
	
	$problems=ManyResultQuery($db, QuerySelect('Problems', ['ContestId'=>$contestId], ['id']));
	
	$v_corrections=[];
	
	foreach($problems as $pro){
		
		$nn=OneResultQuery($db, QuerySelect('Corrections', 
		['ProblemId'=>$pro['id'], 'ContestantId'=>$contestantId], 
		['mark','comment','UserId']
		));
		
		if (is_null($nn)) $nn['done']=false;
		else $nn['done']=true;
		
		$nn['problem']=OneResultQuery($db, QuerySelect('Problems', ['id'=>$pro['id']], ['name']))['name'];
		$nn['username']=OneResultQuery($db, QuerySelect('Users', ['id'=>$nn['UserId']], ['username']))['username'];
		
		$v_corrections[]= $nn;
	}
	$db->close();
	
	TemplatePage("ViewParticipation",[	'Index'=>'index.php',
										'Gare'=>'ViewContests.php',
										$v_contest['name']=>'ViewContestInformation.php?contestId='.$contestId,
										'Partecipanti'=>'ViewContestantsOfAContest.php?contestId='.$contestId,
										$v_contestant['name']." ".$v_contestant['surname']=>'ViewParticipation.php?contestId='.$contestId.'&contestantId='.$contestantId]);
?>
