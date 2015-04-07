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
	$table=['columns'=>$columns, 'rows'=> $rows, 'redirect'=> 'AdminContestInformation', 'id'=> 'AdminContestsTable', 'InitialOrder'=>['ColumnId'=>'date'] ];
	InsertDom( 'table',  $table );
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
		<td> <input type='text' id='ContestInputName'> </td>
		<td> 
			<?php InsertDom( 'date', ['id'=>'ContestInputDate']); ?>
		</td>
		<td> <input type='button' value='Aggiungi' onclick='AddContestRequest()'> </td>
	</tr>
	</table>
</div>
