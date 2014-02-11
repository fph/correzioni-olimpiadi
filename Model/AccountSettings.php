<?php
require_once "../Utilities.php";
SuperRequire_once("General","TemplateCreation.php");

if( !is_null( $_POST["NewUsername" ) ) {
	die();
}

else if ( 0 ) {
	die();
}

TemplatePage("AccountSettings","ClassicUser");
?>
