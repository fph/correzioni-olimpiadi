<?php
global $v_contest;
?>

<h2 class='pageTitle'>
	<span class='contest_title'>
	<?=$v_contest['name']?>
	</span>
	<span class='date_title'>
	<?php 
	if (!is_null($v_contest['date'])) {?>
		- <?=getItalianDate($v_contest['date'])?>
		<?php
	} ?>
	</span>
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
