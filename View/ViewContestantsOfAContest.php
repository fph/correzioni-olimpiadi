<?php
global $v_contest, $v_contestants;
?>

<script>
	function Redirect() {
		document.location="ViewProblem.php?problemId=35";
	}
</script>

<div id="contest">
<?php
	echo $v_contest;
?>
</div>

<table class="InformationTable" id="participationTable">
	<thead><tr>
		<th class='nameColumn'>Name</th>
		<th class='surnameColumn'>Surname</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contestants as $con) {
			echo "<tr class='trlink' onclick=Redirect()>";
			echo "<td class='nameColumn'>".$con["name"]."</td>";
			echo "<td class='surnameColumn'>".$con["surname"]."</td>";
			echo "</tr>";
		}
	?>
	</tbody>
	
</table>
