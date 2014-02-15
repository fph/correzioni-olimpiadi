<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General", "TemplateCreation.php");
	
	$db=OpenDbConnection();
	
	$v_contests=ManyResultQuery($db, QuerySelect('Contests',NULL,NULL,'date'));
	
	foreach($v_contests as &$con){
		$dateAt=$con['date'];
		$con['date']=getItalianDate($dateAt);
	}
	
	$db->close();
	
	TemplatePage("ViewContests",['Index'=>'index.php','Gare'=>'ViewContests.php']);
?>
