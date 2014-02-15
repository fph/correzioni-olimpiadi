<?php
global $v_contest, $v_problem, $v_corrections;
?>

<script>
	function getContestantId(element_this){
		return element_this.getElementsByClassName('surnameColumn')[0].id;
	}
	
	function getProblemId(element_this){
		return document.getElementsByClassName('pageSubtitle')[0].id;
	}
</script>


<h2 class='pageTitle'>
	<?=$v_contest['name']?> 
	<?php 
	if (!is_null($v_contest['date'])) {?>
		- <?=getItalianDate($v_contest['date'])?>
		<?php
	} ?>
</h2>

<h3 class='pageSubtitle' id='<?=$v_problem['id']?>'>
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
		<th class='cancelColumn'></th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_corrections as $cor) {
			?>
			<tr>
			<td class='surnameColumn' id='<?=$cor['contestant']['id']?>'><?=$cor['contestant']['surname']?></td>
			<td class='nameColumn'><?=$cor['contestant']['name']?></td>
			<td class='markColumn'><?=$cor['mark']?></td>
			<td class='commentColumn'><?=$cor['comment']?></td>
			<td class='userColumn'><?=$cor['username']?></td>
			<td class='modifyColumn'> <div class='modifyButtonContainer buttonContainer'>
			<img class='modifyButtonImage buttonImage' src='../View/Images/ModifyButtonImage.png' alt='Modifica' onclick=OnModification(this)>
			</div> </td>
			<td class='cancelColumn'> <div class='cancelButtonContainer buttonContainer'> </div> </td>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<?php
}
?>
