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
if (empty($v_contestants)) {
	?>
	<div class='EmptyTable'> Ancora nessun partecipante inserito. </div>
	<table class='InformationTable hidden'>
	<?php
}
else {
?>
	<div class='EmptyTable hidden'> Ancora nessun partecipante inserito. </div>
	<table class='InformationTable'>
	<?php
}?>
	<thead><tr>
		<th class='SurnameColumn'>Cognome</th>
		<th class='NameColumn'>Nome</th>
		<th class='trash_column'></th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contestants as $con) {
			?>
			<tr data-orderby='<?=$con['surname']?>' data-contestant_id='<?=$con['id']?>'>
			<td class='SurnameColumn'><?=$con['surname']?></td>
			<td class='NameColumn'><?=$con['name']?></td>
			<td class='trash_column'> <div class='ButtonContainer'>
				<img class='ButtonImage' src='../View/Images/TrashButton.png' alt='Elimina' onclick="RemoveParticipationRequest(this)">
			</div> </td>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<h3 class='PageSubtitle'>
	Aggiungi un partecipante
</h3>

<div class='FormContainer'>
	<table>
	<tr>
		<th> Cognome </th>
		<th> Nome </th>
		<th> </th>
	</tr>
	<tr>
		<td> <input type='text' name='surname' id='surname_input'> </td>
		<td> <input type='text' name='name' id='name_input'> </td>
		<td> <input type='button' value='Aggiungi' onclick="AddParticipationRequest()"> </td>
	</tr>
	</table>
</div>

<script>
	var ContestId=<?=$v_contest['id']?>;
</script>
