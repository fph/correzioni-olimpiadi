<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General", "sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "SessionManager.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	$all_contests=ManyResultQuery($db, QuerySelect('Contests'));
	
	$UserId=getUserIdBySession();
	$v_contests=[];
	foreach($all_contests as $contest){
		if (VerifyPermission($db, $UserId, $contest['id'])) $v_contests[]=$contest;
	}
	
	$db->close();
	
	TemplatePage("ViewContests",['Index'=>'index.php','Gare'=>'ViewContests.php']);
?>
