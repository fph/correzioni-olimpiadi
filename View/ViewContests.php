<?php
global $v_contests;
?>

<script>
	function Redirect(contestId) {
		document.location="ViewContestInformation.php?contestId="+contestId;
	}
</script>

<h2 class="pageTitle">
	All contests
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
			echo "<tr class='trlink' onclick=Redirect(".$con['id'].")>";
			echo "<td class='contestColumn'>".$con['name']."</td>";
			echo "</tr>";
		}
	?>
	</tbody>
	
</table>

<?php
}
?>
