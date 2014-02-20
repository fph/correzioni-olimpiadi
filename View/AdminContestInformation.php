<?php
global $v_contest;
?>

<h2 class='PageTitle'>
	<span class='contest_title'> <?=$v_contest['name']?>
	</span>
	<span class='date_title'>
	<?php 
	if (!is_null($v_contest['date'])) {?>
		- <?=GetItalianDate($v_contest['date'])?>
		<?php
	} ?>
	</span>
	
	<span class='buttons_title'>
	<span class='modify_button_container ButtonContainer'>
		<img class='modify_button_image ButtonImage' src='../View/Images/modify_button_image.png' alt='Modifica' title='Modifica gara'>
	</span>
	
	<span class='trash_button_container ButtonContainer'>
		<img class='trash_button_image ButtonImage' src='../View/Images/trash_button_image.png' alt='Elimina' title='Elimina gara' onclick=RemoveContestRequest(<?=$v_contest['id']?>)>
	</span>
	</span>
</h2>

<div class='GeneralInformation'>
	<?php
	if ($v_contest['blocked']) {
		?>
		<div class='CorrectionsInformation CorrectionsCompleted'>
			Correzioni terminate
		</div>
		<?php
	}
	else {
		?>
		<div class='CorrectionsInformation CorrectionsInProgress'>
			Correzioni in corso
		</div>
		<?php
	}?>
</div>

<table class='LinkTable'>
	<tr class='trlink' onclick="Redirect('AdminContestantsOfAContest', {ContestId:<?=$v_contest['id']?>})">
	<td>Partecipanti</td>
	</tr>
	
	<tr class='trlink' onclick="Redirect('AdminProblemsOfAContest', {ContestId:<?=$v_contest['id']?>})">
	<td>Problemi</td>
	</tr>
	
	<tr class='trlink' onclick="Redirect('AdminStatisticsOfAContest', {ContestId:<?=$v_contest['id']?>})">
	<td>Statistiche</td>
	</tr>
</table>
