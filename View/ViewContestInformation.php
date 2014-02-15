<?php
global $v_contest;
?>

<script>
	function RedirectContestants(contestId) {
		document.location="ViewContestantsOfAContest.php?contestId="+contestId;
	}
	
	function RedirectProblems(contestId) {
		document.location="ViewProblemsOfAContest.php?contestId="+contestId;
	}
	
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
	<tr class="trlink" id="LinkToContestants" onclick=RedirectContestants(<?=$v_contest['id']?>)>
	<td>Partecipanti</td>
	</tr>
	
	<tr class="trlink" id="LinkToProblems" onclick=RedirectProblems(<?=$v_contest['id']?>)>
	<td>Problemi</td>
	</tr>
	
	<tr class="trlink" id="LinkToStatistics" onclick=RedirectStatistics(<?=$v_contest['id']?>)>
	<td>Statistiche</td>
	</tr>
</table>
