<?php
global $v_contests;
?>

<h2 class='PageTitle'>
	Lista delle gare
</h2>

<?php
	$columns = [];
	$columns[]= ['id'=>'name', 'name'=>'Gare', 'order'=>1, 'class'=>['ContestColumn']];
	$columns[]= ['id'=>'blocked', 'name'=>'', 'class'=>['CorrectionsCompleted']];
	$columns[]= ['id'=>'date', 'name'=>'Data', 'order'=>1, 'class'=>['DateColumn'], 'order'=>1, 'type'=>'date'];
	
	$rows = [];
	foreach ($v_contests as $contest) {
		$row = ['redirect'=>['ContestId'=>$contest['id']], 'values'=>[
			'name'=> $contest['name'], 'blocked'=>'', 'date'=>$contest['date'] ]
		];
		if ($contest['blocked'] == 1) $row['values']['blocked'] = 'Correzioni terminate';
		$rows[]=$row;
	}
	$table = ['columns'=>$columns, 'rows'=> $rows, 'redirect'=> 'ViewContestInformation', 'InitialOrder'=>['ColumnId'=>'date'] ];
	InsertDom('table',  $table);
?>
