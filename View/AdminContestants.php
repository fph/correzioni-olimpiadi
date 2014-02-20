<?php
global $v_contestants;
?>

<h2 class='PageTitle'>
	Partecipanti
</h2>

<h3 class='PageSubtitle'>
	Lista dei partecipanti
</h3>

<?php
if (empty($v_contestants)) {
	?>
	<div class='EmptyTable'> Ancora nessun partecipante inserito. </div>
	<table class='InformationTable HiddenEmptyTable'>
	<?php
}
else {
?>
	<table class='InformationTable'>
	<?php
}?>
	<thead><tr>
		<th class='surname_column'>Cognome</th>
		<th class='name_column'>Nome</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contestants as $con) {
			?>
			<tr class='trlink' data-orderby='<?=$con['surname']?>' onclick=Redirect('AdminContestantInformation',{ContestantId:<?=$con['id']?>})>
			<td class='surname_column'><?=$con['surname']?></td>
			<td class='name_column'><?=$con['name']?></td>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<h3 class="PageSubtitle">
	Aggiungi un partecipante
</h3>

<div class='createContainer'>
	<table>
	<tr>
		<th> Cognome </th>
		<th> Nome </th>
		<th> </th>
	</tr>
	<tr>
		<td> <input type="text" name="surname" id="surname_input"> </td>
		<td> <input type="text" name="name" id="name_input"> </td>
		<td> <input type="button" value="Aggiungi" onclick=AddContestantRequest()> </td>
	</tr>
	</table>
</div>
