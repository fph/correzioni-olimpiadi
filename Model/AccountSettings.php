<?php
require_once "../Utilities.php";
SuperRequire_once("General","TemplateCreation.php");
SuperRequire_once("General","SessionManager.php");
SuperRequire_once("General","AskInformation.php");

if( !is_null( $_POST["NewUsername"] ) ) {
	$queryResult=changeUsername( $_POST["NewUsername"], GetUsernameBySession() );
	if( $queryResult==1 ) {
		$v_GoodMessage="Username changed successfully."
		TemplatePage("AccountSettings.php","GoodMessage");
	}
	else if( $queryResult==0 ) {
		$v_ErrorMessage="An error occurred changing username, try again.";
		TemplatePage("AccountSettings.php","ErrorMessage");
	}
	die();
}

else if ( 0 ) {
	die();
}

TemplatePage("AccountSettings","ClassicUser");
?>
