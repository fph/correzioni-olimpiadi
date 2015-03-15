<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	$ContestId=$_GET["ContestId"];
	$ContestantId=$_GET["ContestantId"];
	
	CheckPagePermission($db,$ContestId);
	
	//PermissionChecked
	
	$v_MailSent=OneResultQuery($db, QuerySelect('Participations', ['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId], ['email'] ) )['email'];
	
	$v_admin=0;
	if (IsAdmin($db,getUserIdBySession())) $v_admin=1;
	else $v_admin=0;

	$v_contest=OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
	$v_contestant=OneResultQuery($db, QuerySelect('Contestants', ['id'=>$ContestantId]));
	
	$problems=ManyResultQuery($db, QuerySelect('Problems', ['ContestId'=>$ContestId]));
	
	$v_corrections=[];
	
	foreach($problems as $pro){
		$nn=OneResultQuery($db, QuerySelect('Corrections', 
		['ProblemId'=>$pro['id'], 'ContestantId'=>$ContestantId], 
		['mark','comment','UserId']
		));
		
		if (is_null($nn)) {
			$nn['mark']=$nn['UserId']=$nn['username']=null; //UserId is defined only to have the same object structure in both cases.
			$nn['comment']='';
		}
		else {
			$nn['username']=OneResultQuery($db, QuerySelect('Users', ['id'=>$nn['UserId']], ['username']))['username'];
		}
		$nn['problem']=OneResultQuery($db, QuerySelect('Problems', ['id'=>$pro['id']]));
		
		$v_corrections[]= $nn;
	}
	
	
	
	$db->close();
	
	TemplatePage("ViewParticipation",[	'Index'=>'index.php',
										'Gare'=>'ViewContests.php',
										$v_contest['name']=>'ViewContestInformation.php?ContestId='.$ContestId,
										'Partecipanti'=>'ViewContestantsOfAContest.php?ContestId='.$ContestId,
										$v_contestant['name']." ".$v_contestant['surname']=>'ViewParticipation.php?ContestId='.$ContestId.'&amp;ContestantId='.$ContestantId]);
?>
