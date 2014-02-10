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

<table class="InformationTable" id="participationTable">
	<thead><tr>
		<th>Problem</th>
		<th class='markColumn'>Mark</th>
		<th class='commentColumn'>Comment</th>
		<th class='userColumn'>User</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_corrections as $cor) {
			echo "<tr><td class='problemColumn'>".$cor["Problem"]."</td>";
			if ($cor["done"]) {
				echo "<td class='markColumn'>".$cor["mark"]."</td>";
				echo "<td class='commentColumn'>".$cor["comment"]."</td>";
				echo "<td class='userColumn'>".$cor["User"]."</td>";
			}
			else {
				echo "<td class='markColumn'>//</td><td class='commentColumn'>//</td><td class='userColumn'>//</td>";
			}
			echo "</tr>";
		}
	?>
	</tbody>
	
</table>
