<?php
global $v_contestants;
?>

<script>
	function Redirect(contestantId) {
		document.location="AdminContestantInformation.php?contestantId="+contestantId;
	}
	
	function AddContestant() {
		//~ DEBUG
		var surname=document.getElementById('inputSurname');
		var name=document.getElementById('inputName');
		echo(surname);
	}
</script>

<h2 class="pageTitle">
	Partecipanti
</h2>

<h3 class="pageSubtitle">
	Lista dei partecipanti
</h3>

<?php
if (empty($v_contestants)) {
	?>
	<div class='emptyTable'> Ancora nessun partecipante inserito. </div>
	<?php
}
else {
?>

<table class="InformationTable">
	<thead><tr>
		<th class='surnameColumn'>Cognome</th>
		<th class='nameColumn'>Nome</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contestants as $con) {
			?>
			<tr class='trlink' onclick=Redirect(<?=$con['id']?>)>
			<td class='surnameColumn'><?=$con['surname']?></td>
			<td class='nameColumn'><?=$con['name']?></td>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<?php
}
?>

<h3 class="pageSubtitle">
	Aggiungi un partecipante
</h3>

<div class='formContainer'>
	<table>
	<tr>
		<th> Cognome </th>
		<th> Nome </th>
		<th> </th>
	</tr>
	<tr>
<!--
	DEBUG	
-->
		<td> <input type="text" name="surname" id="inputSurname"> </td>
		<td> <input type="text" name="name" id="inputName"> </td>
		<td> <input type="button" value="Aggiungi" onclick=AddContestant()> </td>
	</tr>
	</table>
</div>
