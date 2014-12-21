<?php
global $v_contest, $v_problems;
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
	Lista dei problemi
</h3>

<?php
$columns=[];
$columns[]=['id'=>'problem','name'=>'Problema','class'=>['ProblemColumn'],'order'=>1];

$rows=[];
foreach($v_problems as $problem) {
	$row=['values'=>[
		'problem'=>$problem['name']
		], 'data'=>['problem_id'=>$problem['id'] ] ];
	$rows[]=$row;
}

$buttons=[];
$buttons[]=['name'=>'modify', 'onclick'=>'OnModification'];
$buttons[]=['name'=>'trash', 'onclick'=>'RemoveProblemRequest'];
$buttons[]=['name'=>'confirm', 'onclick'=>'Confirm', 'hidden'=>1];
$buttons[]=['name'=>'cancel', 'onclick'=>'Clear', 'hidden'=>1];

$table=['columns'=>$columns, 'rows'=>$rows, 'buttons'=>$buttons, 'id'=>'AdminProblemsOfAContestTable', 'InitialOrder'=>['ColumnId'=>'problem'] ];

InsertTable($table);
?>



<h3 class='PageSubtitle'>
	Aggiungi un problema
</h3>

<div class='FormContainer'>
	<table>
	<tr>
		<th> Nome </th>
		<th> </th>
	</tr>
	<tr>
		<td> <input type='text' name='name' id='ProblemInput'> </td>
		<td> <input type='button' id='InputButton' value='Aggiungi' onclick="AddProblemRequest()"> </td>
	</tr>
	</table>
</div>


<script>
	var ContestId=<?=$v_contest['id']?>;

</script>
