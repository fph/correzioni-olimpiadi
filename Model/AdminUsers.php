<?php
	
	require_once '../Utilities.php';
	SuperRequire_once('General', 'sqlUtilities.php');
	SuperRequire_once('General', 'TemplateCreation.php');
	SuperRequire_once('General', 'PermissionManager.php');
	
	$db = OpenDbConnection();
	
	CheckPagePermission($db, -1);
	
	//PermissionChecked	
	
	$v_users=ManyResultQuery($db, QuerySelect('Users'));
		
	$db->close();
	
	TemplatePage('AdminUsers', [	'Index'=>'index.php',
										'Amministrazione'=>'AdminAdministration.php',
										'Correttori'=>'AdminUsers.php']);
?>
