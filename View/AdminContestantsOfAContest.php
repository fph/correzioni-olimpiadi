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
	Lista dei partecipanti
</h3>

<?php
$columns=[];
$columns[]=['id'=>'surname', 'name'=>'Cognome', 'class'=>['SurnameColumn'], 'order'=>1];
$columns[]=['id'=>'name', 'name'=>'Nome', 'class'=>['NameColumn']];

$rows=[];
foreach($v_contestants as $contestant) {
	$row=[
	'values'=>['surname'=>$contestant['surname'], 'name'=>$contestant['name']],
	'data'=>['contestant_id'=>$contestant['id']] ];
	$rows[]=$row;
}

$buttons=[];
$buttons[]=['name'=>'trash', 'onclick'=>'RemoveParticipationRequest'];

$table=['columns'=>$columns, 'rows'=>$rows, 'buttons'=>$buttons, 'id'=>'AdminContestantsOfAContestTable'];

InsertTable( $table );
?>

<h3 class='PageSubtitle'>
	Aggiungi un partecipante
</h3>

<div class='FormContainer'>
	<table>
	<tr>
		<th> Partecipante </th>
		<th> </th>
	</tr>
	<tr>
		<td> <?php InsertSelect(['id'=>'ContestantInput', 'type'=>'contestant']); ?></td>
		<td> <input type='button' value='Aggiungi' onclick="AddParticipationRequest()"> </td>
	</tr>
	</table>
</div>

<script>
	var ContestId=<?=$v_contest['id']?>;
</script>
