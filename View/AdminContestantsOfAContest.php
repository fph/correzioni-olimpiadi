<?php
global $v_contest, $v_contestants;
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

<h3 class='PageSubtitle'>
	Lista dei partecipanti
</h3>

<?php
$columns = [];
$columns[] = ['id'=>'surname', 'name'=>'Cognome', 'class'=>['SurnameColumn'], 'order'=>1];
$columns[] = ['id'=>'name', 'name'=>'Nome', 'class'=>['NameColumn']];
$columns[] = ['id'=>'solutions', 'name'=>'Soluzioni', 'class'=>['DownloadColumn']];

$rows = [];
foreach ($v_contestants as $contestant) {
	$SolutionsLink = '';
	if ($contestant['SolutionsBoolean'] === 1) {
		$SolutionsLink = '<a href=\'../Modify/DownloadFiles.php?type=ParticipationPdf&ContestId='.$v_contest['id'].'&ContestantId='.$contestant['id'].'\' download class=\'DownloadIconTable\'><img src=\'../View/Images/DownloadPdf.png\' alt=\'Scarica elaborato\' title=\'Scarica elaborato\'></a>';
	}
	
	$row = [
		'values'=>[
			'surname'=>$contestant['surname'], 
			'name'=>$contestant['name'], 
			'solutions'=>$SolutionsLink
		],
		'data'=>['contestant_id'=>$contestant['id']] 
	];
	$rows[] = $row;
}

$buttons = ['trash'=>['onclick'=>'RemoveParticipationRequest']];

$table = ['columns'=>$columns, 'rows'=>$rows, 'buttons'=>$buttons, 'id'=>'AdminContestantsOfAContestTable', 'InitialOrder'=>['ColumnId'=>'surname']];

InsertDom('table',  $table);
?>

<h3 class='PageSubtitle'>
	Aggiungi un partecipante
</h3>

<?php
$form = ['SubmitText'=>'Aggiungi', 'SubmitFunction'=>'AddParticipationRequest(this.elements)', 'inputs'=>[
	['type'=>'AjaxSelect', 'title'=>'Partecipante', 'select'=>['id'=>'ContestantInput', 'type'=>'contestant', 'name'=>'ContestantId']],
	['type'=>'file', 'title'=>'Elaborato', 'accept'=>'.pdf', 'name'=>'solutions']
]];

InsertDom('form', $form);
?>

<script>
	var ContestId = <?=$v_contest['id']?>;
</script>
