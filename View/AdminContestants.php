<?php
global $v_contestants;
?>

<h2 class='PageTitle'>
	Amministrazione
</h2>

<h3 class='PageSubtitle'>
	Partecipanti
</h3>


<?php

$columns = [];
$columns []= ['id'=>'surname', 'name'=>'Cognome', 'class'=>['SurnameColumn'], 'order'=>1, 'type'=>'string'];
$columns []= ['id'=>'name', 'name'=>'Nome', 'class'=>['NameColumn']];
$columns []= ['id'=>'school', 'name'=>'Scuola', 'class'=>['SchoolColumn']];
$columns []= ['id'=>'email', 'name'=>'Email', 'class'=>['EmailColunm']];
$columns []= ['id'=>'LastOlympicYear', 'name'=>'Ultimo anno IMO', 'order'=>1, 'type'=>'number'];

$rows = [];
foreach ($v_contestants as $contestant) {
	$row = [
	'values'=>[
		'surname'=>$contestant['surname'], 
		'name'=>$contestant['name'], 
		'school'=>$contestant['school'], 
		'email'=>$contestant['email'], 
		'LastOlympicYear'=>$contestant['LastOlympicYear']
	], 'redirect'=>['ContestantId'=>$contestant['id'] ] ];
	$rows[]=$row;
} 

$table = ['columns'=>$columns, 'rows'=>$rows, 'redirect'=>'AdminContestantInformation', 'id'=>'AdminContestantsTable', 'InitialOrder'=>['ColumnId'=>'surname'] ];

InsertDom('table',  $table);
?>


<h3 class='PageSubtitle'>
	Aggiungi un partecipante
</h3>

<?php
$form = ['SubmitText'=>'Aggiungi', 'SubmitFunction'=>'AddContestantRequest(this.elements)', 'inputs'=>[
	['type'=>'text', 'title'=>'Cognome', 'name'=>'surname'],
	['type'=>'text', 'title'=>'Nome', 'name'=>'name'],
	['type'=>'text', 'title'=>'Scuola', 'name'=>'school'],
	['type'=>'email', 'title'=>'Email', 'name'=>'email'],
	['type'=>'number', 'title'=>'Ultimo anno IMO', 'name'=>'LastOlympicYear', 'step'=>'1', 'min'=>'2010']
]];
InsertDom('form', $form);
?>
