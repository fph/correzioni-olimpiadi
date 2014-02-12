<?php
global $v_contest, $v_problem, $v_corrections;
?>


<h2 class="pageTitle">
<?php
	echo $v_contest['name'];
?>
</h2>

<h3 class="pageSubtitle">
<?php
	echo $v_problem['name'];
?>
</h3>

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
			echo "<td class='markColumn'>".$cor['mark']."</td>";
			echo "<td class='commentColumn'>".$cor['comment']."</td>";
			echo "<td class='userColumn'>".$cor['username']."</td>";
			echo "<td class='modifyColumn'> <a target='_blank' class='modifyButton' href=''>Modify</a> </td>";
			echo "</tr>";
		}
	?>
	</tbody>
	
</table>
