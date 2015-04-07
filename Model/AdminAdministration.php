<?php
	
	require_once '../Utilities.php';
	SuperRequire_once('General','sqlUtilities.php');
	SuperRequire_once('General', 'TemplateCreation.php');
	SuperRequire_once('General', 'PermissionManager.php');
	
	$db=OpenDbConnection();
	
	CheckPagePermission($db,-1);
	
	//PermissionChecked	
	
	$db->close();
	
	TemplatePage('AdminAdministration',['Index'=>'index.php',
										'Amministrazione'=>'AdminAdministration.php']);
?>
