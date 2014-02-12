<?php
global $v_contestants;
?>

<script>
	function Redirect(contestantId) {
		document.location="ViewContestantInformation.php?contestantId="+contestantId;
	}
</script>

<h2 class="pageTitle">
	All contestants
</h2>

<table class="InformationTable">
	<thead><tr>
		<th class='nameColumn'>Name</th>
		<th class='surnameColumn'>Surname</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contestants as $con) {
			echo "<tr class='trlink' onclick=Redirect(".$con['id'].")>";
			echo "<td class='nameColumn'>".$con['name']."</td>";
			echo "<td class='surnameColumn'>".$con['surname']."</td>";
			echo "</tr>";
		}
	?>
	</tbody>
	
</table>
