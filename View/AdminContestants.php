<?php
global $v_contestants;
?>

<h2 class='pageTitle'>
	Partecipanti
</h2>

<h3 class='pageSubtitle'>
	Lista dei partecipanti
</h3>

<?php
if (empty($v_contestants)) {
	?>
	<div class='emptyTable'> Ancora nessun partecipante inserito. </div>
	<table class='InformationTable hiddenEmptyTable'>
	<?php
}
else {
?>
	<table class='InformationTable'>
	<?php
}?>
	<thead><tr>
		<th class='surnameColumn'>Cognome</th>
		<th class='nameColumn'>Nome</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contestants as $con) {
			?>
			<tr class='trlink' value='<?=$con['surname']?>' onclick=Redirect('AdminContestantInformation',{contestantId:<?=$con['id']?>})>
			<td class='surnameColumn'><?=$con['surname']?></td>
			<td class='nameColumn'><?=$con['name']?></td>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<h3 class="pageSubtitle">
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
