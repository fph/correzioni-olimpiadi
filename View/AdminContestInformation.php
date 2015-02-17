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
			<?php InsertDom( 'date', ['id'=>'TitleDateModification']); ?>
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

<?php
InsertDom( 'LinkTable', [
	['name'=>'Partecipanti', 'redirect'=>['url'=>'AdminContestantsOfAContest','parameters'=>['ContestId'=>$v_contest['id']] ]],
	['name'=>'Problemi', 'redirect'=>['url'=>'AdminProblemsOfAContest','parameters'=>['ContestId'=>$v_contest['id']] ]],
	['name'=>'Correttori', 'redirect'=>['url'=>'AdminUsersOfAContest','parameters'=>['ContestId'=>$v_contest['id']] ]]
]);
?>

<script>
	var ContestId=<?=$v_contest['id']?>;
</script>
