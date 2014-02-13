<?php
require_once "../Utilities.php";
SuperRequire_once("General","TemplateCreation.php");
SuperRequire_once("General","SessionManager.php");
SuperRequire_once("General","AskInformation.php");

if( !is_null( $_POST["NewUsername"] ) ) {
	$db=OpenDbConnection();
	Query($db, QueryUpdate('Users',['id'=>GetUserIdBySession()],['username'=>$_POST['NewUsername']]));
	
	StartSession(GetUserIdBySession(),$_POST['NewUsername']);
	
	TemplatePage("AccountSettings",['Index'=>'index.php','Configurazione Account'=>'AccountSettings.php'],1,['type'=>'good', 'text'=>'Username changed successfully.']);
	
	die();
}

else if ( 0 ) {
	die();
}

TemplatePage("AccountSettings",['Index'=>'index.php','Configurazione Account'=>'AccountSettings.php']);
?>
