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
</script>

<h2 class="pageTitle">
	<?php
		echo $v_contest['name'];
	?>
</h2>

<table class="TableLink">
	<tr class="trlink" id="LinkToContestants" onclick=RedirectContestants(<?php echo $v_contest['id']; ?>)>
	<td>Partecipanti</td>
	</tr>
	
	<tr class="trlink" id="LinkToProblems" onclick=RedirectProblems(<?php echo $v_contest['id']; ?>)>
	<td>Problemi</td>
	</tr>
	
	<tr class="trlink" id="LinkToStatistics" onclick=RedirectContestants(<?php echo $v_contest['id']; ?>)>
	<td>Statistiche</td>
	</tr>
</table>
