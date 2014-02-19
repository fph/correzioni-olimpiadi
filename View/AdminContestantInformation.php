<?php
global $v_contestant, $v_contests;
?>
<style>
	.ContentEditable {
		border: 1px solid #A8A8A8;
		border-radius: 3px;
	}
	span#ContestantSurname {
		margin: 0 10px 0 0;
	} 	
</style>

<h2 class="pageTitle">
	<span class='contestant_title'>
		<span id='ContestantSurname'> <?=$v_contestant['surname']?> </span>
		<span id='ContestantName'> <?=$v_contestant['name']?> </span>
	</span>
	
	<span class='buttons_title'>
	<span class='modifyButtonContainer buttonContainer'>
		<img class='modifyButtonImage buttonImage' src='../View/Images/ModifyButtonImage.png' alt='Modifica' title='Modifica partecipante' onclick=ModifyContestantName()>
	</span>
	
	<span class='trashButtonContainer buttonContainer'>
		<img class='trashButtonImage buttonImage' src='../View/Images/TrashButtonImage.png' alt='Elimina' title='Elimina partecipante' onclick=RemoveContestantRequest(<?=$v_contestant['id']?>)>
	</span>
	
	<span class='confirmButtonContainer buttonContainer hiddenButtonContainer'>
		<img class='confirmButtonImage buttonImage' src='../View/Images/ConfirmButtonImage.png' alt='Modifica' title='Modifica partecipante' onclick=SendModification(<?=$v_contestant['id']?>)>
	</span>
	
	<span class='cancelButtonContainer buttonContainer hiddenButtonContainer'>
		<img class='cancelButtonImage buttonImage' src='../View/Images/CancelButtonImage.png' alt='Elimina' title='Elimina partecipante' onclick=CancelModification()>
	</span>
	</span>
</h2>

<?php
if (empty($v_contests)) {
	?>
	<div class='emptyTable'> Ancora nessuna gara. </div>
	<?php
}
else {
?>

<table class="InformationTable">
	<thead><tr>
		<th class='contestColumn'>Gara</th>
		<th class='dateColumn'>Data</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contests as $con) {
			?>
			<tr class='trlink' onclick="Redirect('ViewParticipation', {contestId:<?=$con['id']?>, contestantId:<?=$v_contestant['id']?>})">
			<td class='contestColumn'><?=$con['name']?></td>
			<?php if (!is_null($con['date'])) { ?> <td class='dateColumn'><?=getItalianDate($con['date'])?></td> <?php }
			else {?> <td class='dateColumn'>-</td> <?php } ?>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<?php
}
?>
