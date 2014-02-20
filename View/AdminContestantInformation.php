<?php
global $v_contestant, $v_contests;
?>

<h2 class='PageTitle'>
	<span class='contestant_title'>
		<span id='ContestantSurname' style='margin:0 10px 0 0;'><?=$v_contestant['surname']?></span>
		<span id='ContestantName'><?=$v_contestant['name']?></span>
	</span>
	<?php include 'ButtonsTitle.html' ?>
</h2>

<?php
if (empty($v_contests)) {
	?>
	<div class='EmptyTable'> Ancora nessuna gara. </div>
	<?php
}
else {
?>

<table class="InformationTable">
	<thead><tr>
		<th class='contest_column'>Gara</th>
		<th class='date_column'>Data</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contests as $con) {
			?>
			<tr class='trlink' onclick="Redirect('ViewParticipation', {ContestId:<?=$con['id']?>, ContestantId:<?=$v_contestant['id']?>})">
			<td class='contest_column'><?=$con['name']?></td>
			<?php if (!is_null($con['date'])) { ?> <td class='date_column'><?=GetItalianDate($con['date'])?></td> <?php }
			else {?> <td class='date_column'>-</td> <?php } ?>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<?php
}
?>
<script type='text/javascript'>
	var ContestantId=<?=$v_contestant['id']?>;
</script>


