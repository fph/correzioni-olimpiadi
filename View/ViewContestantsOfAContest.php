<?php
global $v_contest, $v_contestants;
?>

<script>
	function Redirect(contestId, contestantId) {
		document.location="ViewParticipation.php?contestId="+contestId+"&contestantId="+contestantId;
	}
</script>

<div id="contest">
<?php
	echo $v_contest['name'];
?>
</div>

<table class="InformationTable" id="contestantsOfAContestTable">
	<thead><tr>
		<th class='nameColumn'>Name</th>
		<th class='surnameColumn'>Surname</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contestants as $con) {
			echo "<tr class='trlink' onclick=Redirect(".$v_contest['id'].",".$con['id'].")>";
			echo "<td class='nameColumn'>".$con['name']."</td>";
			echo "<td class='surnameColumn'>".$con['surname']."</td>";
			echo "</tr>";
		}
	?>
	</tbody>
	
</table>
