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
			<div class='DivToDate'> <?=json_encode(['id'=>'TitleDateModification'])?></div>
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
		<span class='ModifyButtonContainer ButtonContainer'>
			<img class='ModifyButtonImage ButtonImage' src='../View/Images/ModifyButton.png' alt='Modifica' title='Modifica' onclick='ModifyCorrectionsState()'>
		</span>
			
		<span class='ConfirmButtonContainer ButtonContainer hidden'>
			<img class='ConfirmButtonImage ButtonImage' src='../View/Images/ConfirmButton.png' alt='Conferma' title='Conferma' onclick='ConfirmCorrectionsState()'>
		</span>

		<span class='CancelButtonContainer ButtonContainer hidden'>
			<img class='CancelButtonImage ButtonImage' src='../View/Images/CancelButton.png' alt='Annulla' title='Annulla' onclick='CancelCorrectionsState()'>
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
</table>

<script>
	var ContestId=<?=$v_contest['id']?>;
</script>
