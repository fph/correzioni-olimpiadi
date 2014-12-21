<?php
global $v_contest, $v_contestants;
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

<?php
$columns=[];
$columns[]=['id'=>'surname', 'name'=>'Cognome', 'class'=>['SurnameColumn'], 'order'=>1];
$columns[]=['id'=>'name', 'name'=>'Nome', 'class'=>['NameColumn']];
$rows=[];
foreach($v_contestants as $contestant) {
	$row=[
	'values'=>['surname'=>$contestant['surname'], 'name'=>$contestant['name']], 
	'redirect'=>['ContestId'=>$v_contest['id'], 'ContestantId'=>$contestant['id'] ] ];
	$rows[]=$row;
} 

$table=['columns'=>$columns, 'rows'=>$rows, 'redirect'=>'ViewParticipation', 'InitialOrder'=>['ColumnId'=>'surname'] ];

InsertTable( $table );
?>
