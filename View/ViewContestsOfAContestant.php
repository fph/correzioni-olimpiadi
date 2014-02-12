<?php
global $v_contestant, $v_contests;
?>

<script>
	function Redirect(contestId, contestantId) {
		document.location="ViewParticipation.php?contestId="+contestId+"&contestantId="+contestantId;
	}
</script>

<h2 class="pageTitle">
<?php
	echo $v_contestant['name']." ".$v_contestant['surname'];
?>
</h2>

<?php
if (empty($v_contests)) {
	echo "<div class='emptyTable'> No contests yet. </div>";
}
else {
?>

<table class="InformationTable">
	<thead><tr>
		<th class='contestColumn'>Contest</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contests as $con) {
			echo "<tr class='trlink' onclick=Redirect(".$con['id'].",".$v_contestant['id'].")>";
			echo "<td class='contestColumn'>".$con['name']."</td>";
			echo "</tr>";
		}
	?>
	</tbody>
	
</table>

<?php
}
?>
