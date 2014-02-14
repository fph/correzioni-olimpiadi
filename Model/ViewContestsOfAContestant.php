<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	
	$contestantId=$_GET["contestantId"]; 
	
	$db=OpenDbConnection();
	
	$v_contestant=OneResultQuery($db, QuerySelect('Contestants', ['id'=>$contestantId]));
	
	$v_contests=ManyResultQuery($db, QuerySelect('Participations', ['ContestantId'=>$contestantId]));
	
	foreach($v_contests as &$con){
		$con=OneResultQuery($db, QuerySelect('Contests', ['id'=>$con['ContestId']]));
	}
	
	usort($v_contests, build_sorter('date'));
	
	$db->close();
	
	TemplatePage("ViewContestsOfAContestant",[	'Index'=>'index.php',
												'Partecipanti'=>'ViewContestants.php',
												'Gare'=>'ViewContestsOfAContestant.php?contestantId='.$contestantId]);
?>
