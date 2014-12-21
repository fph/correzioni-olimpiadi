<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	$ContestId=$_GET["ContestId"];
	CheckPagePermission($db,$ContestId);
	
	//Permission checked
	
	$v_contest=OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	
	$v_problems=ManyResultQuery($db, QuerySelect('Problems', ['ContestId'=>$ContestId], null));

	usort($v_problems,BuildSorter('name'));
	
	$db->close();
		
	TemplatePage("ViewProblemsOfAContest",[	'Index'=>'index.php',
											'Gare'=>'ViewContests.php',
											$v_contest['name']=>'ViewContestInformation.php?ContestId='.$ContestId,
											'Problemi'=>'ViewProblemsOfAContest.php?ContestId='.$ContestId]);
?>
