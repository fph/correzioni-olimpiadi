
<h2 class='PageTitle'>
	Statistiche
</h2>

<h3 class='PageSubtitle'>
	Aggiungi una gara e il relativo peso
</h3>

<?php
$form = ['SubmitText'=>'Aggiungi', 'SubmitId'=>'AddContestButton', 'SubmitFunction'=>'AddContestToStatistics(this.elements)', 'inputs'=>[
	['type'=>'AjaxSelect', 'title'=>'Gara', 'select'=>['id'=>'ContestInput', 'type'=>'contest', 'name'=>'ContestId']],
	['type'=>'number', 'title'=>'Peso', 'step'=>'0.01', 'name'=>'weight', 'id'=>'WeightInput', 'placeholder'=>'0.5']
]];

InsertDom('form', $form);

$columns = [];
$columns[]= ['id'=>'contest', 'name'=>'Gara', 'order'=>1, 'class'=>['ContestColumn'], 'order'=>1];
$columns[]= ['id'=>'weight', 'name'=>'Peso', 'order'=>1, 'class'=>['WeightColumn'], 'order'=>1, 'type'=>'number'];

$rows = [];

$buttons = [];
$buttons['modify']=['onclick'=>'OnModification'];
$buttons['trash']=['onclick'=>'RemoveContest'];
$buttons['confirm']=['onclick'=>'Confirm', 'hidden'=>1];
$buttons['cancel']=['onclick'=>'Clear', 'hidden'=>1];

$table = ['columns'=>$columns, 'rows'=> $rows, 'buttons'=>$buttons, 'id'=>'AdminContestWeightTable', 'InitialOrder'=>['ColumnId'=>'contest'] ];
InsertDom('table',  $table);
?>

<button id='ViewStatisticsButton' onclick='ViewStatisticsRequest()'>Vedi statistiche</button>
