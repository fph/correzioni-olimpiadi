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

<h3 class='PageSubtitle'>
	<span id='ContestantSchool'>
		<?=$v_contestant['school']?>
	</span>
	<span class='ButtonsSubtitle'>
		<span class='ModifyButtonContainer ButtonContainer'>
			<img class='ModifyButtonImage ButtonImage' src='../View/Images/ModifyButton.png' alt='Modifica' title='Modifica' onclick='ModifySchool()'>
		</span>
			
		<span class='ConfirmButtonContainer ButtonContainer hidden'>
			<img class='ConfirmButtonImage ButtonImage' src='../View/Images/ConfirmButton.png' alt='Conferma' title='Conferma' onclick='ConfirmSchool()'>
		</span>

		<span class='CancelButtonContainer ButtonContainer hidden'>
			<img class='CancelButtonImage ButtonImage' src='../View/Images/CancelButton.png' alt='Annulla' title='Annulla' onclick='CancelSchool()'>
		</span>
	</span>
</h3>

<?php
$columns=[];
$columns[]=['id'=>'contest', 'name'=>'Gara', 'class'=>['ContestColumn'], 'order'=>1, 'type'=>'string'];
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


