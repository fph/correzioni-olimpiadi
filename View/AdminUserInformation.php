<?php
global $v_user, $v_admin, $v_contests;
?>

<h2 class="PageTitle">
	<span id='UsernameTitle'><?=$v_user['username']?></span>
	
	<?php
	if (!$v_admin) include 'ButtonsTitle.html';
	?>
		
</h2>


<?php
if ($v_admin) {
	?>
	<div class='GeneralInformation'>
		<div class='AdminInformation'>
			Amministratore
		</div>
	</div>
	<?php
}?>

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
			<tr class='trlink' onclick="Redirect('ViewContestInformation', {ContestId:<?=$con['id']?>})">
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

<script>
	var UserId=<?=$v_user['id']?>;
</script>
