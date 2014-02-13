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
	?>
<!DOCTYPE html>
<head> 
	<link type='text/css' rel='stylesheet' href='../View/css/global.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/MainBar.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/ShowMessage.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/PagePath.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/InformationTable.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/<?php echo $Content ?>.css'>
</head>

<body>
<?php
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
