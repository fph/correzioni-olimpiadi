<?php
require_once 'Utilities.php';

SuperRequire_once('General','SessionManager.php');

global $jsInclude, $cssInclude;
//$jsInclude, $cssInclude contain the css and js which should be included in the page apart from the standard ones (as global.css)

$jsInclude=['ViewParticipation'=>['CorrectionModification', 'ViewParticipation'], 
			'ViewProblem'=>['CorrectionModification'],
			'ViewRankingOfAContest'=>['ViewRankingOfAContest'], 
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

global $DomInformation;
$DomInformation=[
	'table'=>[], 
	'date'=>[], 
	'select'=>[], 
	'LinkTable'=>[], 
	'buttons'=>[] 
];

function InsertDom( $type, $obj ) {
	global $DomInformation;
?>
	<div class='DivTo<?=ucfirst($type)?> hidden' id='DivTo<?=ucfirst($type)?><?=count($DomInformation[$type])?>'></div>
<?php
	$DomInformation[$type][]=$obj;
}

function TemplatePage($content, $PathDescription, $IsSessionToBeChecked=1, $message=null ){
	if( $IsSessionToBeChecked ){
		$SessionSituation=CheckSession();
		if( $SessionSituation==-1 ) {
			SuperRedirect('Model','Login.php');
			die();
		}
		else if( $SessionSituation==0 ) {
			SuperRedirect('Model','Login.php');
			die();
		}
	}
	global $jsInclude, $cssInclude;
	global $DomInformation;
	?>
<!DOCTYPE html>
<html lang='it'>
<!-- 	
	Correzioni Olimpiadi - Written by walypala23 (Giada Franz) and dario2994 (Federico Glaudo)
	Git repository : https://github.com/walypala23/correzioni-olimpiadi
-->
<head> 
	<meta http-equiv='content-type' content='text/html; charset=UTF-8'>
	<title> Correzioni Olimpiadi</title>
	<link type='text/css' rel='stylesheet' href='../View/css/global.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/MainBar.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/ShowMessage.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/PagePath.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/InformationTable.css'>
	<link type='text/css' rel='stylesheet' href='../View/css/AjaxSelect.css'>
	<link rel='shortcut icon' href='../View/Images/FaviconV4.ico' title='Favicon'>
	
<?php 
	if( isset($cssInclude[$content]) ) {
		foreach( $cssInclude[$content] as $cssName ) {
			?>
			<link type='text/css' rel='stylesheet' href='../View/css/<?=$cssName?>.css'>
			<?php
		} 	
	} ?>
</head>

<body> 
	<?php 
		global $MainBarUserId, $MainBarUsername;
		$MainBarUserId=GetUserIdBySession();
		$MainBarUsername=GetUsernameBySession();
		SuperInclude('View','MainBar.php'); 
	?>
	<div class='internalBody' id='<?=$content?>_InternalBody'>
	
	<?php
		global $v_PathDescription;
		$v_PathDescription=$PathDescription;
		SuperInclude('View','PagePath.php');
	?>
		<div id='ContentContainer'>
			<?php SuperInclude('View',$content.'.php'); ?>
		</div>
	</div>
	
	<div id='MessageList'> </div>
	<script type='text/javascript'>
		var SessionUsername='<?=GetUsernameBySession()?>';
		<?php
		if( !is_null( $message ) ){
			?>
			ShowMessage( '<?=$message['type']?>' , '<?=$message['text']?>' );
			<?php
		} ?>
	</script>
	<script type='text/javascript'>
		var TablesInformation=<?=json_encode( $DomInformation['table'] )?>;
		var DatesInformation=<?=json_encode( $DomInformation['date'] )?>;
		var SelectsInformation=<?=json_encode( $DomInformation['select'] )?>;
		var LinkTablesInformation=<?=json_encode( $DomInformation['LinkTable'] )?>;
		var ButtonsInformation=<?=json_encode( $DomInformation['buttons'] )?>;
	</script>
<!--
	TODO: Si potrebbe evitare di includere questi quando non necessari
-->
	<script type='text/javascript' src='../View/js/global.js'> </script>
	<script type='text/javascript' src='../View/js/ShowMessage.js'> </script>
	<script type='text/javascript' src='../View/js/AjaxManager.js'> </script>
	
	<script type='text/javascript' src='../View/js/ButtonsManager.js'> </script>
	<script type='text/javascript' src='../View/js/TableManager.js'> </script>
	<script type='text/javascript' src='../View/js/AjaxSelect.js'> </script>
	<script type='text/javascript' src='../View/js/DateInput.js'> </script>
	<script type='text/javascript' src='../View/js/LinkTable.js'> </script>
	
	<?php 
	if( isset($jsInclude[$content]) ) {
		foreach( $jsInclude[$content] as $jsName ) {
			?>
			<script type='text/javascript' src='../View/js/<?=$jsName?>.js'> </script>
			<?php
		}
	} ?>
</body>
</html>
	<?php
}
