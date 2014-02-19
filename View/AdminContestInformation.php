<?php
global $v_contest;
?>

<h2 class='pageTitle'>
	<span class='contest_title'> <?=$v_contest['name']?>
	</span>
	<span class='date_title'>
	<?php 
	if (!is_null($v_contest['date'])) {?>
		- <?=getItalianDate($v_contest['date'])?>
		<?php
	} ?>
	</span>
	
	<span class='buttons_title'>
	<span class='modifyButtonContainer buttonContainer'>
		<img class='modifyButtonImage buttonImage' src='../View/Images/ModifyButtonImage.png' alt='Modifica' title='Modifica gara'>
	</span>
	
	<span class='trashButtonContainer buttonContainer'>
		<img class='trashButtonImage buttonImage' src='../View/Images/TrashButtonImage.png' alt='Modifica' title='Elimina gara' onclick=RemoveContestRequest(<?=$v_contest['id']?>)>
	</span>
	</span>
</h2>

<div class='generalInformation'>
	<?php
	if ($v_contest['blocked']) {
		?>
		<div class='corrections_information correctionsCompleted'>
			Correzioni terminate
		</div>
		<?php
	}
	else {
		?>
		<div class='corrections_information correctionsInProgress'>
			Correzioni in corso
		</div>
		<?php
	}?>
</div>

<table class="TableLink">
	<tr class="trlink" id="LinkToContestants" onclick="Redirect('AdminContestantsOfAContest', {contestId:<?=$v_contest['id']?>})">
	<td>Partecipanti</td>
	</tr>
	
	<tr class="trlink" id="LinkToProblems" onclick="Redirect('AdminProblemsOfAContest', {contestId:<?=$v_contest['id']?>})">
	<td>Problemi</td>
	</tr>
	
	<tr class="trlink" id="LinkToStatistics" onclick="Redirect('AdminStatisticsOfAContest', {contestId:<?=$v_contest['id']?>})">
	<td>Statistiche</td>
	</tr>
</table>
