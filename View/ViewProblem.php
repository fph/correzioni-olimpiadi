<?php
global $v_contest, $v_problem, $v_corrections;
?>


<h2 class="pageTitle">
	<?=$v_contest['name']?>
</h2>

<h3 class="pageSubtitle">
	<?=$v_problem['name']?>
</h3>

<?php
if (empty($v_corrections)) {
	?>
	<div class='emptyTable'> Ancora nessuna correzione. </div>
	<?php
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
			?>
			<tr>
			<td class='surnameColumn'><?=$cor['contestant']['surname']?></td>
			<td class='nameColumn'><?=$cor['contestant']['name']?></td>
			<td class='markColumn'><?=$cor['mark']?></td>
			<td class='commentColumn'><?=$cor['comment']?></td>
			<td class='userColumn'><?=$cor['username']?></td>
			<td class='modifyColumn'> <div class='modifyButtonContainer' onclick=prova()>
			<img class='modifyButtonImage' src='../View/Images/ModifyButtonImage.png'}>
			</div> </td>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<?php
}
?>
