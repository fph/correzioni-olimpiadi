<?php
global $v_contest;
?>

<h2 class='PageTitle'>
	<span>
	<?=$v_contest['name']?>
	</span>
	<span>
	<?php 
	if (!is_null($v_contest['date'])) {?>
		- <?=GetItalianDate($v_contest['date'])?>
		<?php
	} ?>
	</span>
</h2>

<table class="LinkTable">
	<tr class="trlink" onclick="Redirect('ViewContestantsOfAContest', {ContestId:<?=$v_contest['id']?>})">
	<td>Partecipanti</td>
	</tr>
	
	<tr class="trlink"onclick="Redirect('ViewProblemsOfAContest', {ContestId:<?=$v_contest['id']?>})">
	<td>Problemi</td>
	</tr>
	
	<tr class="trlink" onclick="Redirect('ViewStatisticsOfAContest', {ContestId:<?=$v_contest['id']?>})">
	<td>Statistiche</td>
	</tr>
</table>
