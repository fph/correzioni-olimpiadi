<?php
global $v_contest, $v_contestants;
?>

<script>
	function Redirect(contestId, contestantId) {
		document.location="ViewParticipation.php?contestId="+contestId+"&contestantId="+contestantId;
	}
</script>

<h2 class="pageTitle">
<?php
	echo $v_contest['name'];
?>
</h2>

<?php
if (empty($v_contestants)) {
	echo "<div class='emptyTable'> Ancora nessun partecipante inserito. </div>";
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
			echo "<tr class='trlink' onclick=Redirect(".$v_contest['id'].",".$con['id'].")>";
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
