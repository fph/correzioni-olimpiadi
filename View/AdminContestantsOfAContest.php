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
$columns []= ['id'=>'surname', 'name'=>'Cognome', 'class'=>['SurnameColumn'], 'order'=>1];
$columns []= ['id'=>'name', 'name'=>'Nome', 'class'=>['NameColumn']];
$columns []= ['id'=>'solutions', 'name'=>'Soluzioni'];

$rows = [];
foreach ($v_contestants as $contestant) {
	$row = [
		'values'=>[
			'surname'=>$contestant['surname'], 
			'name'=>$contestant['name'], 
			'solutions'=>'<a href=\'../Modify/ManageFiles.php?type=ParticipationFile&ContestId='.$v_contest['id'].'&ContestantId='.$contestant['id'].'\' download><img src=\'../View/Images/DownloadPdf.png\' alt=\'Scarica elaborato\'></a>'
		],
		'data'=>['contestant_id'=>$contestant['id']] 
	];
	$rows []= $row;
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
