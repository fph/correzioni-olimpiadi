<?php
global $v_contestant, $v_contests;
?>

<h2 class='PageTitle'>
	<span class='contestant_title'>
		<span id='ContestantSurname' style='margin: 0 10px 0 0; '><?=$v_contestant['surname']?></span>
		<span id='ContestantName'><?=$v_contestant['name']?></span>
	</span>
	<?php InsertDom('buttons', ['title'=>true]) ?>
</h2>

<h3 class='PageSubtitle'>
	<span id='ContestantSchool'><?=$v_contestant['school']?></span>
<?php
	$ButtonsSubtitle1 = ['class'=>['ButtonsSubtitle'], 'buttons'=>[
		'modify'=>['onclick'=>'ModifySchool()'], 
		'confirm'=>['onclick'=>'ConfirmSchool()', 'hidden'=>true], 
		'cancel'=>['onclick'=>'CancelSchool()', 'hidden'=>true] 
	]];
	InsertDom('buttons', $ButtonsSubtitle1);
?>
</h3>

<h3 class='PageSubtitle'>
	<span id='ContestantSchoolCity'><?=$v_contestant['SchoolCity']?></span>
<?php
	$ButtonsSubtitle2 = ['class'=>['ButtonsSubtitle'], 'buttons'=>[
		'modify'=>['onclick'=>'ModifySchoolCity()'], 
		'confirm'=>['onclick'=>'ConfirmSchoolCity()', 'hidden'=>true], 
		'cancel'=>['onclick'=>'CancelSchoolCity()', 'hidden'=>true] 
	]];
	InsertDom('buttons', $ButtonsSubtitle2);
?>
</h3>

<h3 class='PageSubtitle'>
	<span id='ContestantEmail'><?=$v_contestant['email']?></span>
<?php
	$ButtonsSubtitle3 = ['class'=>['ButtonsSubtitle'], 'buttons'=>[
		'modify'=>['onclick'=>'ModifyEmail()'], 
		'confirm'=>['onclick'=>'ConfirmEmail()', 'hidden'=>true], 
		'cancel'=>['onclick'=>'CancelEmail()', 'hidden'=>true] 
	]];
	InsertDom('buttons', $ButtonsSubtitle3);
?>
</h3>

<h3 class='PageSubtitle'>
	<span>Ultimo anno IMO: </span>
	<span id='ContestantLastOlympicYear'><?=$v_contestant['LastOlympicYear']?></span>
<?php
	$ButtonsSubtitle4 = ['class'=>['ButtonsSubtitle'], 'buttons'=>[
		'modify'=>['onclick'=>'ModifyLastOlympicYear()'], 
		'confirm'=>['onclick'=>'ConfirmLastOlympicYear()', 'hidden'=>true], 
		'cancel'=>['onclick'=>'CancelLastOlympicYear()', 'hidden'=>true] 
	]];
	InsertDom('buttons', $ButtonsSubtitle4);
?>
</h3>

<?php
$columns = [];
$columns[]=['id'=>'contest', 'name'=>'Gara', 'class'=>['ContestColumn'], 'order'=>1, 'type'=>'string'];
$columns[]=['id'=>'date', 'name'=>'Data', 'class'=>['DateColumn'], 'order'=>1, 'type'=>'date'];

$rows = [];
foreach ($v_contests as $contest) {
	$row = [
	'values'=>['contest'=>$contest['name'], 'date'=>$contest['date'] ], 
	'redirect'=>['ContestId'=>$contest['id'], 'ContestantId'=>$v_contestant['id'] ] ];
	$rows[]=$row;
} 

$table = ['columns'=>$columns, 'rows'=>$rows, 'redirect'=>'ViewParticipation', 'InitialOrder'=>['ColumnId'=>'date'] ];

InsertDom('table',  $table);
?>


<script type='text/javascript'>
	var ContestantId = <?=$v_contestant['id']?>;
</script>


