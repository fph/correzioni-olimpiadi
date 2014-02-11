<?php
global $v_contest, $v_problem, $v_corrections;
?>


<div id="problemInfo">
<?php
	echo $v_contest['name']." - ".$v_problem['name'];
?>
</div>

<table class="InformationTable" id="problemTable">
	<thead><tr>
		<th class='nameColumn'>Name</th>
		<th class='surnameColumn'>Surname</th>
		<th class='markColumn'>Mark</th>
		<th class='commentColumn'>Comment</th>
		<th class='userColumn'>User</th>
		<th class='modifyColumn'></th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_corrections as $cor) {
			echo "<tr><td class='nameColumn'>".$cor['contestant']['name']."</td>";
			echo "<td class='surnameColumn'>".$cor['contestant']['surname']."</td>";
			if ($cor["done"]) {
				echo "<td class='markColumn'>".$cor['mark']."</td>";
				echo "<td class='commentColumn'>".$cor['comment']."</td>";
				echo "<td class='userColumn'>".$cor['user']."</td>";
				echo "<td class='modifyColumn'> <a target='_blank' class='modifyButton' href=''>Modify</a> </td>";
			}
			else {
				echo "<td class='markColumn'>-</td><td class='commentColumn'>-</td><td class='userColumn'>-</td>";
				echo "<td class='modifyColumn'> <a target='_blank' class='modifyButton' href=''>Modify</a> </td>";
			}
			echo "</tr>";
		}
	?>
	</tbody>
	
</table>
