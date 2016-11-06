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
			<?php InsertDom('date', ['id'=>'TitleDateModification']); ?>
		</span>
	</span>
	
	<?php InsertDom('buttons', ['title'=>true]); ?>
</h2>

<div class='GeneralInformation'>
	<div id='CorrectionsInformationContainer' data-value='<?=($v_contest['blocked'])?'block': 'unblock'?>'>
		<span id='CorrectionsStateSpan' class='<?= ($v_contest['blocked'])?'CorrectionsCompleted': 'CorrectionsInProgress'?>'>
			<?= ($v_contest['blocked'])?'Correzioni terminate': 'Correzioni in corso'?>
		</span>
		
		<select id='CorrectionsStateSelect' class='hidden'>
			<option value='block'>Correzioni terminate</option>
			<option value='unblock'>Correzioni in corso</option>
		</select>
	
<?php
	$buttons = ['class'=> ['ButtonsSubtitle'], 'buttons'=>[
		'modify'=>['onclick'=>'ModifyCorrectionsState()'], 
		'confirm'=>['onclick'=>'ConfirmCorrectionsState()', 'hidden'=>true], 
		'cancel'=>['onclick'=>'CancelCorrectionsState()', 'hidden'=>true]
	]];
	InsertDom('buttons', $buttons);
?>
	</div>
	
	<div id='SolutionsZipInformationContainer'>
		<input id='SolutionsZipButton' type='submit' value='<?=(is_null($v_contest['SolutionsZip']))?'Genera':'Rigenera'?> lo zip degli elaborati' onclick='CreateZip()'>
	</div>
</div>

<?php
InsertDom('LinkTable', [
	['name'=>'Partecipanti', 'redirect'=>['url'=>'AdminContestantsOfAContest', 'parameters'=>['ContestId'=>$v_contest['id']] ]],
	['name'=>'Problemi', 'redirect'=>['url'=>'AdminProblemsOfAContest', 'parameters'=>['ContestId'=>$v_contest['id']] ]],
	['name'=>'Correttori', 'redirect'=>['url'=>'AdminUsersOfAContest', 'parameters'=>['ContestId'=>$v_contest['id']] ]]
]);
?>

<div class='ExtraDataContainer'>
	<h3>Indirizzo email a cui inoltrare le richieste di partecipazione</h3>
	<p>
		Al seguente indirizzo email saranno inoltrate tutte le richieste di partecipazione alla gara. Se questo campo è lasciato vuoto le richieste non sono inviate a nessuno. Le email mandate, indifferentemente dall'indirizzo inserito, avranno come intestazione "Gentile segreteria UMI".
	</p>
	<input id='ForwardRegistrationEmailInput' type='email' value='<?= $v_contest['ForwardRegistrationEmail']?>'>
	<input id='ForwardRegistrationEmailButton' type='submit' onclick='ChangeForwardRegistrationEmail()' value='Salva indirizzo'>
</div>

<div class='ExtraDataContainer'>
	<h3>Mail personalizzata per i segati</h3>
	<p>
		Qui potete scrivere il paragrafo centrale della mail da mandare ai segati.
		Questo testo sarà preceduto da "Caro Nome," e seguito dal verbalino di correzione. 
	</p>
	<textarea id='NotAcceptedEmailTextarea' placeholder='Ci dispiace, ma i tuoi esercizi non sono risultati sufficienti per essere ammesso allo stage.
Questo è il verbale di correzione dei tuoi esercizi: '><?= $v_contest['NotAcceptedEmail']?></textarea>
	<input id='NotAcceptedEmailButton' type='submit' onclick='ChangeNotAcceptedEmail()' value='Salva paragrafo'>
</div>
<script>
	var ContestId = <?=$v_contest['id']?>;
</script>
