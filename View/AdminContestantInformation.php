<?php
global $v_contestant, $v_contests;
?>


<h2 class="pageTitle">
	<span class='contestant_title'>
		<?=$v_contestant['surname']?> <?=$v_contestant['name']?>
	</span>
	
	<span class='buttons_title'>
	<span class='modifyButtonContainer buttonContainer'>
		<img class='modifyButtonImage buttonImage' src='../View/Images/ModifyButtonImage.png' alt='Modifica' title='Modifica'>
	</span>
	
	<span class='trashButtonContainer buttonContainer'>
		<img class='trashButtonImage buttonImage' src='../View/Images/TrashButtonImage.png' alt='Modifica' title='Elimina'>
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
