<?php
global $v_user, $v_admin, $v_contests;
?>

<h2 class='PageTitle'>
	<span id='UsernameTitle'><?=$v_user['username']?></span>
	
	<?php
	if (!$v_admin) include 'ButtonsTitle.html';
	?>
		
</h2>


<?php
if ($v_admin) {
	?>
	<div class='GeneralInformation'>
		<div class='AdminInformation'>
			Amministratore
		</div>
	</div>
	<?php
}?>

<?php
$columns=[];
$columns[]=['id'=>'contest', 'name'=>'Gara', 'class'=>['ContestColumn'], 'order'=>1, 'type'=>'string'];
$columns[]=['id'=>'date', 'name'=>'Data', 'class'=>['DateColumn'], 'order'=>1, 'type'=>'date'];

$rows=[];
foreach($v_contests as $contest) {
	$row=[
	'values'=>['contest'=>$contest['name'], 'date'=>$contest['date']], 
	'redirect'=>['ContestId'=>$contest['id'] ] ];
	$rows[]=$row;
} 

$table=['columns'=>$columns, 'rows'=>$rows, 'redirect'=>'ViewContestInformation', 'InitialOrder'=>['ColumnId'=>'date']];

InsertTable( $table );
?>

<script>
	var UserId=<?=$v_user['id']?>;
</script>
