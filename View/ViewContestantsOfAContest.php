<?php
global $v_contest, $v_contestants;
?>

<h2 class='pageTitle'>
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

<?php
if (empty($v_contestants)) {
	?>
	<div class='emptyTable'> Ancora nessun partecipante inserito. </div>
	<?php
}
else {
?>

<table class="InformationTable" id="contestantsOfAContestTable">
	<thead><tr>
		<th class='surnameColumn'>Cognome</th>
		<th class='nameColumn'>Nome</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contestants as $con) {
			?>
			<tr class='trlink' onclick="Redirect('ViewParticipation', {contestId:<?=$v_contest['id']?>,contestantId:<?=$con['id']?>})">
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
