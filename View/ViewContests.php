<?php
global $v_contests;
?>

<script>
	function Redirect(contestId) {
		document.location="ViewContestInformation.php?contestId="+contestId;
	}
</script>

<table class="InformationTable" id="contestsTable">
	<thead><tr>
		<th class='contestColumn'>Contest</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contests as $con) {
			echo "<tr class='trlink' onclick=Redirect(".$con['id'].")>";
			echo "<td class='nameColumn'>".$con['name']."</td>";
			echo "</tr>";
		}
	?>
	</tbody>
	
</table>
