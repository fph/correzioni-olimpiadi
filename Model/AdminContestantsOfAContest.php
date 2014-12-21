<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	CheckPagePermission($db,-1);
	
	//PermissionChecked
	
	$ContestId=$_GET['ContestId'];
	
	$v_contest=OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	
	$v_contestants=ManyResultQuery($db, QuerySelect('Participations', ['ContestId'=>$ContestId]));
	
	foreach($v_contestants as &$con){
		$con=OneResultQuery($db, QuerySelect('Contestants', ['id'=>$con['ContestantId']]));
	}
	
	usort($v_contestants, BuildSorter('surname'));
	
	
	
	$db->close();
	
	TemplatePage('AdminContestantsOfAContest',[	'Index'=>'index.php',
												'Amministrazione'=>'AdminAdministration.php',
												'Gare'=>'AdminContests.php',
												$v_contest['name']=>'AdminContestInformation.php?ContestId='.$ContestId,
												'Partecipanti'=>'AdminContestantsOfAContest.php?ContestId='.$ContestId]);
?>
