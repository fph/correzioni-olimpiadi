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

<?php
if (empty($v_contestants)) {
	?>
	<div class='EmptyTable'> Ancora nessun partecipante inserito. </div>
	<?php
}
else {
?>

<table class="InformationTable">
	<thead><tr>
		<th class='SurnameColumn'>Cognome</th>
		<th class='NameColumn'>Nome</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contestants as $con) {
			?>
			<tr class='trlink' onclick="Redirect('ViewParticipation', {ContestId:<?=$v_contest['id']?>,ContestantId:<?=$con['id']?>})">
			<td class='SurnameColumn'><?=$con['surname']?></td>
			<td class='NameColumn'><?=$con['name']?></td>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<?php
}
?>
