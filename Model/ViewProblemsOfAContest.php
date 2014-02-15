<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	$contestId=$_GET["contestId"];
	CheckPagePermission($db,$contestId);
	
	//Permission checked
	
	$v_contest=OneResultQuery($db, QuerySelect('Contests', ['id'=>$contestId]));	
	
	$v_problems=ManyResultQuery($db, QuerySelect('Problems', ['ContestId'=>$contestId]));
	
	$db->close();
		
	TemplatePage("ViewProblemsOfAContest",[	'Index'=>'index.php',
											'Gare'=>'ViewContests.php',
											$v_contest['name']=>'ViewContestInformation.php?contestId='.$contestId,
											'Problemi'=>'ViewProblemsOfAContest.php?contestId='.$contestId]);
?>
