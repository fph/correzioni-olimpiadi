<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	CheckPagePermission($db,-1);
	
	//PermissionChecked	
	
	$contestantId=$_GET["contestantId"];
	
	$v_contestant=OneResultQuery($db, QuerySelect('Contestants', ['id'=>$contestantId]));
	
	$v_contests=ManyResultQuery($db, QuerySelect('Participations', ['ContestantId'=>$contestantId]));
	
	foreach($v_contests as &$con){
		$con=OneResultQuery($db, QuerySelect('Contests', ['id'=>$con['ContestId']]));
	}
	
	usort($v_contests, build_sorter('date'));
	
	$db->close();
	
	TemplatePage("AdminContestantInformation",[	'Index'=>'index.php',
												'Amministrazione'=>'AdminAdministration.php',
												'Partecipanti'=>'AdminContestants.php',
												$v_contestant['surname']." ".$v_contestant['name']=>'ViewContestsOfAContestant.php?contestantId='.$contestantId]);
?>
