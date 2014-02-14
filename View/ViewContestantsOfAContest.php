<?php
global $v_contest, $v_contestants;
?>

<script>
	function Redirect(contestId, contestantId) {
		document.location="ViewParticipation.php?contestId="+contestId+"&contestantId="+contestantId;
	}
</script>

<h2 class="pageTitle">
<?=$v_contest['name'];?>
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
			<tr class='trlink' onclick=Redirect(<?=$v_contest['id']?>,<?=$con['id']?>)>
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
