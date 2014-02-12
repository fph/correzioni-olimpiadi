<?php
require_once "Utilities.php";

SuperRequire_once("General","SessionManager.php");


function TemplatePage($Content, $PathDescription, $IsSessionToBeChecked=1, $Message=NULL ){
	if( $IsSessionToBeChecked ){
		$SessionSituation=CheckSession();
		if( $SessionSituation==-1 ) {
			SuperRedirect("Model","Login.php");
			die();
		}
		else if( $SessionSituation==0 ) {
			SuperRedirect("Model","Login.php");
			die();
		}
	}
	echo '<head> <style type="text/css">';
	SuperInclude("View","global.css");
	SuperInclude("View","InformationTable.css");
	SuperInclude("View","MainBar.css");
	SuperInclude("View","PagePath.css");
	SuperInclude("View",$Content.".css");
	if( !is_null( $Message ) ) SuperInclude("View","ShowMessage.css");
	echo '</style></head><body>';
	
	if( !is_null( $Message ) ){
		global $v_Message;
		$v_Message=$Message;
		SuperInclude("View","ShowMessage.php");
	}
	SuperInclude("View","MainBar.php");
	
	echo '<div class="internalBody" id="'.$Content.'_InternalBody">';
	
	global $v_PathDescription;
	$v_PathDescription=$PathDescription;
	SuperInclude("View","PagePath.php");
	
	echo '<div id="ContentContainer">';
	SuperInclude("View",$Content.".php");
	echo '</div></div></body>';
}

?>
