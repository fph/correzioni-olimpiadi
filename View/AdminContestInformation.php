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
	
	<?php InsertDom('buttons', ['title'=>true]); ?>
</h2>

<div class='GeneralInformation'>
	<div id='CorrectionsInformationContainer' data-value='<?=($v_contest['blocked'])?'block':'unblock'?>'>
		<span id='CorrectionsStateSpan' class='<?= ($v_contest['blocked'])?'CorrectionsCompleted':'CorrectionsInProgress'?>'>
			<?= ($v_contest['blocked'])?'Correzioni terminate':'Correzioni in corso'?>
		</span>
		
		<select id='CorrectionsStateSelect' class='hidden'>
			<option value='block'>Correzioni terminate</option>
			<option value='unblock'>Correzioni in corso</option>
		</select>
	
<?php
	$buttons=[ 'class'=> ['ButtonsSubtitle'], 'buttons'=>[
		'modify'=>['onclick'=>'ModifyCorrectionsState()'], 
		'confirm'=>['onclick'=>'ConfirmCorrectionsState()', 'hidden'=>true], 
		'cancel'=>['onclick'=>'CancelCorrectionsState()', 'hidden'=>true]
	] ];
	InsertDom('buttons', $buttons);
?>
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
