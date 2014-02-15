<?php
global $v_corrections, $v_contestant, $v_contest;
?>

<script>
	function getContestantId(element_this){
		return document.getElementsByClassName('pageSubtitle')[0].id;
	}
	
	function getProblemId(element_this){
		return element_this.getElementsByClassName('problemColumn')[0].id;
	}
</script>

<h2 class="pageTitle">
	<?=$v_contest['name']?>
	<?php 
	if (!is_null($v_contest['date'])) {?>
		- <?=getItalianDate($v_contest['date'])?>
		<?php
	} ?>
</h2>

<h3 class="pageSubtitle" id="<?=$v_contestant['id']?>">
<?=$v_contestant['surname']?> <?=$v_contestant['name']?>
</h3>

<?php
if (empty($v_corrections)) {
	?>
	<div class='emptyTable'> Ancora nessuna correzione. </div>
	<?php
}
else {
?>

<table class="InformationTable" id="participationTable">
	<thead><tr>
		<th class='problemColumn'>Problema</th>
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
			<tr id='Participation<?=$cor['problem']['id']?>'><td class='problemColumn' id='<?=$cor['problem']['id']?>'><?=$cor['problem']['name']?></td>
			
			<?php
			if ($cor["done"]) {
				?>
				<td class='markColumn'><?=$cor['mark']?></td>
				<td class='commentColumn'><?=$cor['comment']?></td>
				<td class='userColumn'><?=$cor['username']?></td>
				<?php
			}
			else {
				?>
				<td class='markColumn'>-</td><td class='commentColumn'>-</td><td class='userColumn'>-</td>
				<?php
			}
			?>
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
