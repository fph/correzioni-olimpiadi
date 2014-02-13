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

<?php
if (empty($v_corrections)) {
	echo "<div class='emptyTable'> Ancora nessuna correzione. </div>";
}
else {
?>

<table class="InformationTable" id="problemTable">
	<thead><tr>
		<th class='surnameColumn'>Cognome</th>
		<th class='nameColumn'>Nome</th>
		<th class='markColumn'>Voto</th>
		<th class='commentColumn'>Commento</th>
		<th class='userColumn'>Correttore</th>
		<th class='modifyColumn'></th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_corrections as $cor) {
			echo "<tr>";
			echo "<td class='surnameColumn'>".$cor['contestant']['surname']."</td>";
			echo "<td class='nameColumn'>".$cor['contestant']['name']."</td>";
			echo "<td class='markColumn'>".$cor['mark']."</td>";
			echo "<td class='commentColumn'>".$cor['comment']."</td>";
			echo "<td class='userColumn'>".$cor['username']."</td>";
			echo "<td class='modifyColumn'> <div class='modifyButtonContainer' onclick=prova()>";
			echo "<img class='modifyButtonImage' src='../View/Images/ModifyButtonImage.png'}>";
			echo "</div> </td>";
			echo "</tr>";
		}
	?>
	</tbody>
	
</table>

<?php
}
?>
