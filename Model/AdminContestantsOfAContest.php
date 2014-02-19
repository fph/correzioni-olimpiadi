<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	CheckPagePermission($db,-1);
	
	//PermissionChecked
	
	$contestId=$_GET["contestId"];
	
	$v_contest=OneResultQuery($db, QuerySelect('Contests', ['id'=>$contestId]));
	
	$v_contestants=ManyResultQuery($db, QuerySelect('Participations', ['ContestId'=>$contestId]));
	
	foreach($v_contestants as &$con){
		$con=OneResultQuery($db, QuerySelect('Contestants', ['id'=>$con['ContestantId']]));
	}
	
	usort($v_contestants, build_sorter('surname'));
	
	
	
	$db->close();
	
	TemplatePage("AdminContestantsOfAContest",[	'Index'=>'index.php',
												'Amministrazione'=>'AdminAdministration.php',
												'Gare'=>'AdminContests.php',
												$v_contest['name']=>'AdminContestInformation.php?contestId='.$contestId,
												'Partecipanti'=>'AdminContestantsOfAContest.php?contestId='.$contestId]);
?>
