<?php
require_once "Utilities.php";

SuperRequire_once("General","SessionManager.php");

function TemplatePage($Content, $Bar, $IsSessionToBeChecked=1 ){
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
	echo '</style></head><body>';
	echo 	'<div class="ContainerBar" id="'.$Bar.'_ContainerBar">
				<div id="Floater">
					<div class="innerBar">';
						SuperInclude("View",$Bar."_bar.php");
	echo '</div></div></div>';
	echo '<div id="internalBody">';
	SuperInclude("View",$Content);
	echo '</div></body>';
}

?>
