<?php
global $v_contestant, $v_contests;
?>

<script>
	function Redirect(contestId, contestantId) {
		document.location="ViewParticipation.php?contestId="+contestId+"&contestantId="+contestantId;
	}
</script>

<h2 class="pageTitle">
	<?=$v_contestant['surname']?> <?=$v_contestant['name']?>
</h2>

<?php
if (empty($v_contests)) {
	?>
	<div class='emptyTable'> No contests yet. </div>
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
			<tr class='trlink' onclick=Redirect(<?=$con['id']?>,<?=$v_contestant['id']?>)>
			<td class='contestColumn'><?=$con['name']?></td>
			<?php if (!is_null($con['date'])) { ?> <td class='dateColumn'><?=$con['date']?></td> <?php }
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
