<?php
global $v_contestants;
?>

<script>
	function Redirect(contestantId) {
		document.location="ViewContestsOfAContestant.php?contestantId="+contestantId;
	}
</script>

<h2 class="pageTitle">
	Tutti i partecipanti
</h2>

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
