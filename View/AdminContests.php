<?php
global $v_contests;
?>

<h2 class='PageTitle'>
	Amministrazione
</h2>

<h3 class='PageSubtitle'>
	Gare
</h3>

<?php
	$columns = [];
	$columns[]= ['id'=>'name', 'name'=>'Gare', 'order'=>1, 'class'=>['ContestColumn'], 'order'=>1];
	$columns[]= ['id'=>'blocked', 'name'=>'', 'class'=>['CorrectionsCompleted']];
	$columns[]= ['id'=>'date', 'name'=>'Deadline', 'order'=>1, 'class'=>['DateColumn'], 'order'=>1, 'type'=>'date'];
	
	$rows = [];
	foreach ($v_contests as $contest) {
		$row = ['redirect'=>['ContestId'=>$contest['id']], 'values'=>[
			'name'=> $contest['name'], 'blocked'=>'', 'date'=>$contest['date'] ]
		];
		if ($contest['blocked'] == 1) $row['values']['blocked'] = 'Correzioni terminate';
		$rows[]= $row;
	}
	$table = ['columns'=>$columns, 'rows'=> $rows, 'redirect'=> 'AdminContestInformation', 'id'=> 'AdminContestsTable', 'InitialOrder'=>['ColumnId'=>'date'] ];
	InsertDom('table',  $table);
?>

<h3 class='PageSubtitle'>
	Aggiungi una gara
</h3>

<?php
$form = ['SubmitText'=>'Aggiungi', 'SubmitFunction'=>'AddContestRequest(this.elements)', 'inputs'=>[
	['type'=>'text', 'title'=>'Nome', 'name'=>'name'],
	['type'=>'date', 'title'=>'Deadline', 'date'=>['id'=>'ContestInputDate', 'name'=>'date']],
	['type'=>'email', 'title'=>'Email inoltro domande', 'name'=>'ForwardRegistrationEmail', 'value'=>'dipmat.umi@unibo.it'],
]];
InsertDom('form', $form);
?>
