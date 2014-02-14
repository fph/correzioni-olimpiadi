<?php
require_once "Utilities.php";

SuperRequire_once("General","SessionManager.php");

global $jsInclude, $cssInclude;
$jsInclude=['ViewParticipation'=>['CorrectionModification'], 'ViewProblem'=>['CorrectionModification'] ];
$cssInclude=[];

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
	global $jsInclude, $cssInclude;
	?>
<!DOCTYPE html>
<head> 
	<title> Correzioni Olimpiadi</title>
	<link type='text/css' rel='stylesheet' href='../View/css/global.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/MainBar.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/ShowMessage.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/PagePath.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/InformationTable.css'>

<?php foreach( $cssInclude[$Content] as $cssName ) {
		?>
		<link type='text/css' rel='stylesheet' href='../View/css/<?=$cssName?>.css'>
		<?php
	} ?>	

	<script type='text/javascript' src='../View/js/ShowMessage.js'> </script>
	<script type='text/javascript' src='../View/js/AjaxManager.js'> </script>
<?php foreach( $jsInclude[$Content] as $jsName ) {
		?>
		<script type='text/javascript' src='../View/js/<?=$jsName?>.js'> </script>
		<?php
	} ?>
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
	<script type='text/javascript'>
		var SessionUsername='<?=GetUsernameBySession()?>';
		<?php
		if( !is_null( $Message ) ){
			?>
			ShowMessage( '<?=$Message['type']?>' , '<?=$Message['text']?>' );
			<?php
		} ?>
	</script>
</body>

	<?php
}
?>
