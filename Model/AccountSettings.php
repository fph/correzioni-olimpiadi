<?php
require_once "../Utilities.php";
SuperRequire_once("General","TemplateCreation.php");
SuperRequire_once("General","SessionManager.php");
SuperRequire_once("General","AskInformation.php");

if( !is_null( $_POST["NewUsername"] ) ) {
	$db=OpenDbConnection();
	Query($db, QueryUpdate('Users',['id'=>GetUserIdBySession()],['username'=>$_POST['NewUsername']]));
	
	StartSession(GetUserIdBySession(),$_POST['NewUsername']);
	
	$v_GoodMessage="Username changed successfully.";
	TemplatePage("AccountSettings","GoodMessage");
	
	die();
}

else if ( 0 ) {
	die();
}

TemplatePage("AccountSettings","ClassicUser");
?>
