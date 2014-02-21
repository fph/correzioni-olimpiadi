<?php
global $v_contest;
?>

<h2 class='PageTitle'>
	<span id='name_title'><?=$v_contest['name']?></span>
	<span id='date_title'>
		<span id='ItalianDate' data-raw_date='<?=$v_contest['date']?>'>
			<?php 
			if (!is_null($v_contest['date'])) {?>
				- <?=GetItalianDate($v_contest['date'])?>
				<?php
			} ?>
		</span>
		<span class='hidden' id='DateModificationContainer'>
			<?php include 'DateInput.html' ?>
		</span>
	</span>
	
	<?php include 'ButtonsTitle.html'?>
</h2>

<div class='GeneralInformation'>
	<div id='CorrectionsInformationContainer'>
	<?php
	if ($v_contest['blocked']) {
		?>
		<span class='CorrectionsState CorrectionsCompleted'>
			Correzioni terminate
		</span>
		<?php
	}
	else {
		?>
		<span class='CorrectionsState CorrectionsInProgress'>
			Correzioni in corso
		</span>
		<?php
	}?>
	<span class='ButtonsSubtitle'>
	<span class='modify_button_container ButtonContainer'>
		<img class='modify_button_image ButtonImage' src='../View/Images/modify_button_image.png' alt='Modifica' title='Modifica' onclick='OnModificationCorrectionsState()'>
		</span>
		
	<span class='confirm_button_container ButtonContainer hidden'>
		<img class='confirm_button_image ButtonImage' src='../View/Images/confirm_button_image.png' alt='Conferma' title='Conferma' onclick='ConfirmCorrectionsState()'>
	</span>

	<span class='cancel_button_container ButtonContainer hidden'>
		<img class='cancel_button_image ButtonImage' src='../View/Images/cancel_button_image.png' alt='Annulla' title='Annulla' onclick='ClearCorrectionsState()'>
	</span>
	</span>
	</div>
</div>

<table class='LinkTable'>
	<tr class='trlink' onclick="Redirect('AdminContestantsOfAContest', {ContestId:<?=$v_contest['id']?>})">
	<td>Partecipanti</td>
	</tr>
	
	<tr class='trlink' onclick="Redirect('AdminProblemsOfAContest', {ContestId:<?=$v_contest['id']?>})">
	<td>Problemi</td>
	</tr>

	<tr class='trlink' onclick="Redirect('AdminUsersOfAContest', {ContestId:<?=$v_contest['id']?>})">
	<td>Correttori</td>
	</tr>
	
	<tr class='trlink' onclick="Redirect('AdminStatisticsOfAContest', {ContestId:<?=$v_contest['id']?>})">
	<td>Statistiche</td>
	</tr>
</table>

<script>
	var ContestId=<?=$v_contest['id']?>;
</script>
