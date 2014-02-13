<?php
global $v_contests;
?>

<script>
	function Redirect(contestId) {
		document.location="ViewContestInformation.php?contestId="+contestId;
	}
</script>

<h2 class="pageTitle">
	Tutte le gare
</h2>

<?php
if (empty($v_contests)) {
	echo "<div class='emptyTable'> Ancora nessuna gara inserita. </div>";
}
else {
?>

<table class="InformationTable">
	<thead><tr>
		<th class='contestColumn'>Gare</th>
		<th class='dateColumn'>Data</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contests as $con) {
			echo "<tr class='trlink' onclick=Redirect(".$con['id'].")>";
			echo "<td class='contestColumn'>".$con['name']."</td>";
			if (!is_null($con['date']))echo "<td class='dateColumn'>".$con['date']."</td>";
			else echo "<td class='dateColumn'>-</td>";
			echo "</tr>";
		}
	?>
	</tbody>
	
</table>

<?php
}
?>
