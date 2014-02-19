<?php
global $v_contest, $v_contestants;
?>

<h2 class='PageTitle'>
	<span class='contest_title'>
	<?=$v_contest['name']?>
	</span>
	<span class='date_title'>
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
		<th class='surname_column'>Cognome</th>
		<th class='name_column'>Nome</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contestants as $con) {
			?>
			<tr class='trlink' onclick="Redirect('ViewParticipation', {ContestId:<?=$v_contest['id']?>,ContestantId:<?=$con['id']?>})">
			<td class='surname_column'><?=$con['surname']?></td>
			<td class='name_column'><?=$con['name']?></td>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<?php
}
?>
