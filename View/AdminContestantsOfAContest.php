<?php
global $v_contest, $v_contestants;
?>

<h2 class='pageTitle' value='<?=$v_contest['id']?>'>
	<span class='contest_title'>
	<?=$v_contest['name']?>
	</span>
	<span class='date_title'>
	<?php 
	if (!is_null($v_contest['date'])) {?>
		- <?=getItalianDate($v_contest['date'])?>
		<?php
	} ?>
	</span>
</h2>

<h3 class='pageSubtitle'>
	Lista dei partecipanti
</h3>

<?php
if (empty($v_contestants)) {
	?>
	<div class='emptyTable'> Ancora nessun partecipante inserito. </div>
	<table class="InformationTable hiddenEmptyTable">
	<?php
}
else {
?>
	<table class="InformationTable">
	<?php
}?>
	<thead><tr>
		<th class='surnameColumn'>Cognome</th>
		<th class='nameColumn'>Nome</th>
		<th class='trashColumn'></th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contestants as $con) {
			?>
			<tr value='<?=$con['id']?>'>
			<td class='surnameColumn'><?=$con['surname']?></td>
			<td class='nameColumn'><?=$con['name']?></td>
			<td class='trashColumn'> <div class='trashButtonContainer buttonContainer'>
				<img class='trashButtonImage buttonImage' src='../View/Images/TrashButtonImage.png' alt='Elimina' onclick=RemoveParticipationRequest(this)>
			</div> </td>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<h3 class='pageSubtitle'>
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
		<td> <input type="button" value="Aggiungi" onclick=AddParticipationRequest()> </td>
	</tr>
	</table>
</div>


