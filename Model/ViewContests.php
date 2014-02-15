<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "SessionManager.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	$all_contests=ManyResultQuery($db, QuerySelect('Contests',NULL,NULL,'date'));
	
	$UserId=getUserIdBySession();
	$v_contests=[];
	foreach($all_contests as $con){
		if (VerifyPermission($db, $UserId, $con['id'])) $v_contests[]=$con;
	}
	
	$db->close();
	
	TemplatePage("ViewContests",['Index'=>'index.php','Gare'=>'ViewContests.php']);
?>
