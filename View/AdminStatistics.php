
<h2 class='PageTitle'>
	Statistiche
</h2>

<h3 class='PageSubtitle'>
	Aggiungi una gara e il relativo peso
</h3>

<div class='FormContainer'>
	<table>
	<tr>
		<th> Gara </th>
		<th> Peso </th>
		<th> </th>
	</tr>
	<tr>
		<td> <?php InsertDom('select', ['id'=>'ContestInput', 'type'=>'contest']); ?> </td>
		<td> <input type='number' step='0.01' name='weight' id='WeightInput' placeholder='0.5'> </td>
		<td> <input type='button' value='Aggiungi' id='AddContestButton' onclick='AddContestToStatistics()'> </td>
	</tr>
	</table>
</div>

<?php
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
