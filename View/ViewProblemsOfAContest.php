<?php
global $v_contest, $v_contestId, $v_problems;
?>

<script>
	function Redirect(problemId) {
		document.location="ViewProblem.php?problemId="+problemId;
	}
</script>

<div id="contest">
<?php
	echo $v_contest;
?>
</div>

<table class="InformationTable">
	<thead><tr>
		<th class='problemColumn'>Problem</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_problems as $pro) {
			echo "<tr class='trlink' onclick=Redirect(".$pro["id"].")>";
			echo "<td class='problemColumn'>".$pro["name"]."</td>";
			echo "</tr>";
		}
	?>
	</tbody>
	
</table>
