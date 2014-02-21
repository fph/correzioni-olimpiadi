<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	SuperRequire_once("General", "PermissionManager.php");
	
	$db=OpenDbConnection();
	
	CheckPagePermission($db,-1);
	
	//PermissionChecked	
	
	$v_contestants=ManyResultQuery($db, QuerySelect('Contestants'));

	usort($v_contestants, build_sorter('surname'));
		
	$db->close();
	
	TemplatePage("AdminContestants",[	'Index'=>'index.php',
										'Amministrazione'=>'AdminAdministration.php',
										'Partecipanti'=>'AdminContestants.php']);
?>
