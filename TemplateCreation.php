<?php
require_once "Utilities.php";

function TemplatePage($Content, $Bar){
	echo '<head> <style type="text/css">';
	SuperInclude("View","global.css");
	echo '</style></head><body>';
	SuperInclude("View",$Bar);
	echo '<div id="internalBody">';
	SuperInclude("View",$Content);
	echo '</div></body>';
}

?>
