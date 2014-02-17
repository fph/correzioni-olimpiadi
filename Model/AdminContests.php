<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	CheckPagePermission($db,-1);
	
	//PermissionChecked	
	
	$v_contests=ManyResultQuery($db, QuerySelect('Contests',NULL,NULL,'date'));
		
	$db->close();
	
	TemplatePage("AdminContests",[	'Index'=>'index.php',
									'Amministrazione'=>'AdminAdministration.php',
									'Gare'=>'AdminContests.php']);
?>
