<?php
require_once "Utilities.php";

function TemplatePage($Content, $Bar){
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
