<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	CheckPagePermission($db,-1);
	
	//PermissionChecked	
	
	$userId=$_GET["userId"];
	
	$v_user=OneResultQuery($db, QuerySelect('Users', ['id'=>$userId]));
	
	$v_admin=false;
	$v_contests=[];
	
	if(!is_null(OneResultQuery($db, QuerySelect('Administrators', ['UserId'=>$userId]))) ) {
		$v_admin=true;
		$v_contests=ManyResultQuery($db, QuerySelect('Contests', null, null, 'date'));
	}
	else {
		$contests=ManyResultQuery($db, QuerySelect('Permissions', ['UserId'=>$userId]));
		foreach($contests as $con) {
			$v_contests[]=OneResultQuery($db, QuerySelect('Contests', ['id'=>$con['ContestId']]));
			usort($v_contests, build_sorter('date'));
		}
	}
	
	//~ $v_contests=ManyResultQuery($db, QuerySelect('Participations', ['ContestantId'=>$contestantId]));
	//~ 
	//~ foreach($v_contests as &$con){
		//~ $con=OneResultQuery($db, QuerySelect('Contests', ['id'=>$con['ContestId']]));
	//~ }
	
	//~ usort($v_contests, build_sorter('date'));
	
	$db->close();
	
	TemplatePage("AdminUserInformation",[	'Index'=>'index.php',
												'Amministrazione'=>'AdminAdministration.php',
												'Correttori'=>'AdminUsers.php',
												$v_user['username']=>'AdminUserInformation.php?contestantId='.$contestantId]);
?>
