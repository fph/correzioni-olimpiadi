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
	echo "<div class='emptyTable'> Ancora nessun partecipante inserito. </div>";
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
			echo "<tr class='trlink' onclick=Redirect(".$con['id'].")>";
			echo "<td class='surnameColumn'>".$con['surname']."</td>";
			echo "<td class='nameColumn'>".$con['name']."</td>";
			echo "</tr>";
		}
	?>
	</tbody>
	
</table>

<?php
}
?>
