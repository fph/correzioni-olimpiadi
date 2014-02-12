<?php
global $v_contest, $v_problems;
?>

<script>
	function Redirect(problemId) {
		document.location="ViewProblem.php?problemId="+problemId;
	}
</script>

<h2 class="pageTitle" id="contest">
<?php
	echo $v_contest['name'];
?>
</h2>

<?php
if (empty($v_problems)) {
	echo "<div class='emptyTable'> No problems yet. </div>";
}
else {
?>

<table class="InformationTable" id="problemsOfAContestTable">
	<thead><tr>
		<th class='problemColumn'>Problem</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_problems as $pro) {
			echo "<tr class='trlink' onclick=Redirect(".$pro['id'].")>";
			echo "<td class='problemColumn'>".$pro['name']."</td>";
			echo "</tr>";
		}
	?>
	</tbody>
	
</table>

<?php
}
?>
