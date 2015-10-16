<?php
	
	require_once '../Utilities.php';
	// SuperRequire_once('General', 'sqlUtilities.php');
	SuperRequire_once('General', 'TemplateCreation.php');
	SuperRequire_once('General', 'PermissionManager.php');

	$db = OpenDbConnection();
	
	CheckPagePermission($db, -2);
	
	$db->close();
	//PermissionChecked	
	TemplatePage('Configurations', ['Index'=>'index.php', 
									'Configurazioni'=>'Configurations.php']);
