<?php
	require_once '../Utilities.php';
	SuperRequire_once('General', 'TemplateCreation.php');
	SuperRequire_once('General', 'SessionManager.php');
	SuperRequire_once('General', 'PermissionManager.php');
	
	$db = OpenDbConnection();
	
	$v_admin=0;
	if (IsAdmin($db, getUserIdBySession())) $v_admin=1;
	else $v_admin=0;
	
	$db->close();
	
	TemplatePage('index', ['Index'=>'index.php']);
?>
