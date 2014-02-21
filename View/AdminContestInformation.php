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

<script>
	var ContestId=<?=$v_contest['id']?>;
</script>
