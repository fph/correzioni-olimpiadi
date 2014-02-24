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
	$columns[]= ['id'=>'name', 'name'=>'Gare', 'order'=>1, 'class'=>['ContestColumn']];
	$columns[]= ['id'=>'blocked', 'name'=>'', 'class'=>['CorrectionsCompleted']];
	$columns[]= ['id'=>'date', 'name'=>'Data', 'order'=>1, 'class'=>['DateColumn']];
	
	$rows=[];
	foreach( $v_contests as $contest ) {
		$row=['redirect'=>['ContestId'=>$contest['id']], 'values'=>[
			'name'=> $contest['name'], 'blocked'=>'', 'date'=>GetItalianDate($contest['date'])]
		];
		if( $contest['blocked']==1 ) $row['values']['blocked'] = 'Correzioni terminate';
		$rows[]=$row;
	}
	$Table=['columns'=>$columns, 'rows'=> $rows, 'redirect'=> 'AdminContestInformation'];
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
		<td> <input type="text" name="name" id="NameInput"> </td>
		<td> 
			<?php include 'DateInput.html' ?>
		</td>
		<td> <input type="button" value="Aggiungi" onclick=AddContestRequest()> </td>
	</tr>
	</table>
</div>
