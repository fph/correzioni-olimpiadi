<?php
global $v_corrections, $v_contestant, $v_contest_name;
?>

<div id="contest">
<?php
	echo $v_contest_name."<br>";
?>
</div>

<div id="contestant">
<?php
	echo $v_contestant["name"]." ".$v_contestant["surname"]."<br>";
?>
</div>

<table id="participationTable">
	<tr>
		<th>Problem</th>
		<th>Mark</th>
		<th>Comment</th>
		<th>User</th>
	</tr>
	<?php
		foreach($v_corrections as $cor) {
			echo "<tr><td>".$cor["Problem"]."</td>";
			if ($cor["done"]) {
				echo "<td>".$cor["mark"]."</td>";
				echo "<td>".$cor["comment"]."</td>";
				echo "<td>".$cor["User"]."</td>";
			}
			else {
				echo "<td>//</td><td>//</td><td>//</td>";
			}
			echo "</tr>";
		}
	?>

</table>
