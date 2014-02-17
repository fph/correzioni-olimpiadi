<?php
global $v_contestant, $v_contests;
?>

<h2 class="pageTitle">
	<?=$v_contestant['surname']?> <?=$v_contestant['name']?>
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
