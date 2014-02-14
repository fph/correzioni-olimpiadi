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
	<title> Correzioni Olimpiadi</title>
	<link type='text/css' rel='stylesheet' href='../View/css/global.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/MainBar.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/ShowMessage.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/PagePath.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/InformationTable.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/<?=$Content?>.css'>
	<script type='text/javascript' src='../View/ShowMessage.js'> </script>
	<script type='text/javascript' src='../View/AjaxManager.js'> </script>
</head>

<body> 
	<?php SuperInclude("View","MainBar.php"); ?>
	<div class="internalBody" id="<?=$Content;?>_InternalBody">
	
	<?php
		global $v_PathDescription;
		$v_PathDescription=$PathDescription;
		SuperInclude("View","PagePath.php");
	?>
		<div id="ContentContainer">
			<?php SuperInclude("View",$Content.".php"); ?>
		</div>
	</div>
	
	<div id='MessageList'> </div>
	<?php
	if( !is_null( $Message ) ){
		?>
		<script>
			ShowMessage( '<?=$Message['type']?>' , '<?=$Message['text']?>' );
		</script>
		<?php
	}
	?>
</body>

	<?php
}
?>
