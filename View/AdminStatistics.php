
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
		<td> <input type='text' name='name' id='ContestInput'> </td>
		<td> <input type='number' step='0.01' name='weight' id='WeightInput'> </td>
		<td> <input type='button' value='Aggiungi' id='AddContestButton' onclick=AddContestToStatistics()> </td>
	</tr>
	</table>
</div>

<?php
	$columns=[];
	$columns[]= ['id'=>'contest', 'name'=>'Gara', 'order'=>1, 'class'=>['ContestColumn'], 'order'=>1];
	$columns[]= ['id'=>'weight', 'name'=>'Peso', 'order'=>1, 'class'=>['WeightColumn'], 'order'=>1, 'type'=>'number'];
	
	$rows=[];

	$buttons=[];
	$buttons[]=['name'=>'modify', 'onclick'=>'OnModification'];
	$buttons[]=['name'=>'trash', 'onclick'=>'RemoveContest'];
	$buttons[]=['name'=>'confirm', 'onclick'=>'Confirm', 'hidden'=>1];
	$buttons[]=['name'=>'cancel', 'onclick'=>'Clear', 'hidden'=>1];
	
	$Table=['columns'=>$columns, 'rows'=> $rows, 'buttons'=>$buttons, 'InitialOrder'=>['ColumnId'=>'contest'], 'id'=>'AdminContestWeightTable' ];
	InsertTable( $Table );
?>

<button id='ViewStatisticsButton' onclick='ViewStatisticsRequest()'>Vedi statistiche</button>
