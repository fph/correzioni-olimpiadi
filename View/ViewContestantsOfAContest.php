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
<h3 class='PageSubtitle'>
	Partecipanti
</h3>

<?php
$columns = [];
$columns[]=['id'=>'surname', 'name'=>'Cognome', 'class'=>['SurnameColumn'], 'order'=>1];
$columns[]=['id'=>'name', 'name'=>'Nome', 'class'=>['NameColumn']];
$columns[] = ['id'=>'LastYear', 'name'=>'Ultimo Anno', 'class'=>['LastYearColumn'], 'order'=>1, 'type'=>'number'];
$columns[] = ['id'=>'PastCamps', 'name'=>'Pise', 'class'=>['PastCampsColumn'], 'order'=>1, 'type'=>'number'];
$rows = [];
foreach ($v_contestants as $contestant) {
	$row = [
	'values'=>['surname'=>$contestant['surname'], 'name'=>$contestant['name'], 'LastYear'=>$contestant['LastOlympicYear'], 'PastCamps'=>$contestant['PastCamps']],
	'redirect'=>['ContestId'=>$v_contest['id'], 'ContestantId'=>$contestant['id'] ] ];
	$rows[]=$row;
}

$table = ['columns'=>$columns, 'rows'=>$rows, 'redirect'=>'ViewParticipation', 'InitialOrder'=>['ColumnId'=>'surname'] ];

InsertDom('table',  $table);
?>
