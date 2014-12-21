<?php
require_once "Utilities.php";

SuperRequire_once("General","SessionManager.php");

global $jsInclude, $cssInclude;
//$jsInclude, $cssInclude contain the css and js which should be included in the page apart from the standard ones (as global.css)

$jsInclude=['ViewParticipation'=>['CorrectionModification'], 
			'ViewProblem'=>['CorrectionModification'], 
			'AdminContestants'=>['AdminContestants'], 
			'AdminUsers'=>['AdminUsers'], 
			'AdminContests'=>['AdminContests'],
			'AdminProblemsOfAContest'=>['AdminProblemsOfAContest'], 
			'AdminContestantInformation'=>['AdminContestantInformation'],
			'AdminUserInformation'=>['AdminUserInformation'], 
			'AdminContestInformation'=>['AdminContestInformation'],
			'AdminContestantsOfAContest'=>['AdminContestantsOfAContest'],
			'AdminUsersOfAContest'=>['AdminUsersOfAContest'],
			'AdminStatistics'=>['AdminStatistics'] ];
$cssInclude=['AdminStatistics'=>['AdminStatistics'],
			'ViewParticipation'=>['ViewParticipation'] ];

$tablesInformation=[];
$datesInformation=[];
$selectsInformation=[];
function InsertTable( $table ) {
	global $tablesInformation;
?>
	<div class='DivToTable hidden' id='DivToTable<?=count($tablesInformation)?>'></div>
<?php 
	$tablesInformation[]=$table;
}

function InsertDate( $date ) {
	global $datesInformation;
?>
	<div class='DivToDate hidden' id='DivToDate<?=count($datesInformation)?>'></div>
<?php 
	$datesInformation[]=$date;
}

function InsertSelect( $select ) {
	global $selectsInformation;
?>
	<div class='DivToSelect hidden' id='DivToSelect<?=count($selectsInformation)?>'></div>
<?php 
	$selectsInformation[]=$select;
}

function TemplatePage($Content, $PathDescription, $IsSessionToBeChecked=1, $Message=null ){
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
	global $tablesInformation, $datesInformation, $selectsInformation;
	?>
<!DOCTYPE html>
<html lang='it'>
<!-- 	
	Correzioni Olimpiadi - Written By walypala23 (Giada Franz) and dario2994 (Federico Glaudo)
	Git repository : https://github.com/walypala23/correzioni-olimpiadi
-->
<head> 
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title> Correzioni Olimpiadi</title>
	<link type='text/css' rel='stylesheet' href='../View/css/global.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/MainBar.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/ShowMessage.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/PagePath.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/InformationTable.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/AjaxSelect.css'>
<!-- <link rel="shortcut icon" href="../View/Images/Favicon.ico" title="Favicon"> -->

<?php 
	if( isset($cssInclude[$Content]) ) {
		foreach( $cssInclude[$Content] as $cssName ) {
			?>
			<link type='text/css' rel='stylesheet' href='../View/css/<?=$cssName?>.css'>
			<?php
		} 	
	} ?>
	<script type='text/javascript' src='../View/js/global.js'> </script>
	<script type='text/javascript' src='../View/js/ShowMessage.js'> </script>
	<script type='text/javascript' src='../View/js/AjaxManager.js'> </script>
<?php 
	if( isset($jsInclude[$Content]) ) {
		foreach( $jsInclude[$Content] as $jsName ) {
			?>
			<script type='text/javascript' src='../View/js/<?=$jsName?>.js'> </script>
			<?php
		}
	} ?>
</head>

<body> 
	<?php 
		global $MainBarUserId, $MainBarUsername;
		$MainBarUserId=GetUserIdBySession();
		$MainBarUsername=GetUsernameBySession();
		SuperInclude("View","MainBar.php"); 
	?>
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
	<script type='text/javascript'>
		var tablesInformation=<?=json_encode( $tablesInformation )?>;
		var datesInformation=<?=json_encode( $datesInformation )?>;
		var selectsInformation=<?=json_encode( $selectsInformation )?>;
	</script>
	<script type='text/javascript' src='../View/js/TableManager.js'> </script>
	<script type='text/javascript' src='../View/js/AjaxSelect.js'> </script>
	<script type='text/javascript' src='../View/js/DateInput.js'> </script>
</body>
</html>
	<?php
}
?>
