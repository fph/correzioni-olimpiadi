<?php
global $v_contests;
?>

<h2 class='PageTitle'>
	Gare
</h2>

<h3 class='PageSubtitle'>
	Lista delle gare
</h3>

<?php
	$columns=[];
	$columns[]= ['id'=>'name', 'name'=>'Gare', 'order'=>1, 'class'=>['ContestColumn'], 'order'=>1];
	$columns[]= ['id'=>'blocked', 'name'=>'', 'class'=>['CorrectionsCompleted']];
	$columns[]= ['id'=>'date', 'name'=>'Data', 'order'=>1, 'class'=>['DateColumn'], 'order'=>1, 'type'=>'date'];
	
	$rows=[];
	foreach( $v_contests as $contest ) {
		$row=['redirect'=>['ContestId'=>$contest['id']], 'values'=>[
			'name'=> $contest['name'], 'blocked'=>'', 'date'=>$contest['date'] ]
		];
		if( $contest['blocked']==1 ) $row['values']['blocked'] = 'Correzioni terminate';
		$rows[]=$row;
	}
	$Table=['columns'=>$columns, 'rows'=> $rows, 'redirect'=> 'AdminContestInformation', 'id'=> 'AdminContestsTable', 'InitialOrder'=>['ColumnId'=>'date'] ];
	InsertTable( $Table );
?>

<h3 class='PageSubtitle'>
	Aggiungi una gara
</h3>

<div class='FormContainer'>
	<table>
	<tr>
		<th> Nome </th>
		<th> Data </th>
		<th> </th>
	</tr>
	<tr>
		<td> <input type="text" id="ContestInputName"> </td>
		<td> 
			<div class='DivToDate'> <?=json_encode(['id'=>'ContestInputDate'])?></div>
		</td>
		<td> <input type="button" value="Aggiungi" onclick="AddContestRequest()"> </td>
	</tr>
	</table>
</div>
