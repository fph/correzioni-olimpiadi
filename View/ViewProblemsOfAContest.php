<?php
global $v_contest, $v_problems;
?>

<h2 class='PageTitle'>
	<span> <?=$v_contest['name']?>
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
	Problemi
</h3>

<?php
$columns=[];
$columns[]=['id'=>'problem', 'name'=>'Problema', 'class'=>['ProblemColumn'], 'order'=>1];

$rows=[];
foreach ($v_problems as $problem) {
	$row=[
	'values'=>['problem'=>$problem['name']], 
	'redirect'=>['ContestId'=>$v_contest['id'], 'ProblemId'=>$problem['id'] ] ];
	$rows[]=$row;
}

$table=['columns'=>$columns, 'rows'=>$rows, 'redirect'=>'ViewProblem', 'InitialOrder'=>['ColumnId'=>'problem'] ];

InsertDom( 'table', $table);
?>
