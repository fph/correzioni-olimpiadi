<?php
global $v_contestant, $v_contests;
?>

<h2 class='PageTitle'>
	<span class='contestant_title'>
		<span id='ContestantSurname' style='margin:0 10px 0 0;'><?=$v_contestant['surname']?></span>
		<span id='ContestantName'><?=$v_contestant['name']?></span>
	</span>
	<?php include 'ButtonsTitle.html' ?>
</h2>


<?php
$columns=[];
$columns[]=['id'=>'contest', 'name'=>'Gara', 'class'=>['ContestColumn']];
$columns[]=['id'=>'date', 'name'=>'Data', 'class'=>['DateColumn'], 'order'=>1, 'type'=>'date'];

$rows=[];
foreach($v_contests as $contest) {
	$row=[
	'values'=>['contest'=>$contest['name'], 'date'=>$contest['date'] ], 
	'redirect'=>['ContestId'=>$contest['id'], 'ContestantId'=>$v_contestant['id'] ] ];
	$rows[]=$row;
} 

$table=['columns'=>$columns, 'rows'=>$rows, 'redirect'=>'ViewParticipation', 'InitialOrder'=>['ColumnId'=>'date'] ];

InsertTable( $table );
?>


<script type='text/javascript'>
	var ContestantId=<?=$v_contestant['id']?>;
</script>


