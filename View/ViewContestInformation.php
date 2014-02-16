<?php
global $v_contest;
?>

<script>
	function RedirectStatistics(contestId){
		document.location="ViewStatisticsOfAContest.php?contestId="+contestId;
	}
</script>

<h2 class="pageTitle">
	<?=$v_contest['name']?>
	<?php 
	if (!is_null($v_contest['date'])) {?>
		- <?=getItalianDate($v_contest['date'])?>
		<?php
	} ?>
</h2>

<table class="TableLink">
	<tr class="trlink" id="LinkToContestants" onclick="Redirect('ViewContestantsOfAContest', {contestId:<?=$v_contest['id']?>})">
	<td>Partecipanti</td>
	</tr>
	
	<tr class="trlink" id="LinkToProblems" onclick="Redirect('ViewProblemsOfAContest', {contestId:<?=$v_contest['id']?>})">
	<td>Problemi</td>
	</tr>
	
	<tr class="trlink" id="LinkToStatistics" onclick="Redirect('ViewStatisticsOfAContest', {contestId:<?=$v_contest['id']?>})">
	<td>Statistiche</td>
	</tr>
</table>
