<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General", "sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	$ContestId=$_GET['ContestId'];
	
	CheckPagePermission($db,$ContestId);
	
	//PermissionChecked	
	
	$v_contest=OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	
	$v_contestants=ManyResultQuery($db, QuerySelect('Participations', ['ContestId'=>$ContestId]));
	
	foreach($v_contestants as &$con){
		$con=OneResultQuery($db, QuerySelect('Contestants', ['id'=>$con['ContestantId']]));
	}
	
	
	$db->close();
	
	TemplatePage("ViewContestantsOfAContest",[	'Index'=>'index.php',
												'Gare'=>'ViewContests.php',
												$v_contest['name']=>'ViewContestInformation.php?ContestId='.$ContestId,
												'Partecipanti'=>'ViewContestantsOfAContest.php?ContestId='.$ContestId]);
?>
