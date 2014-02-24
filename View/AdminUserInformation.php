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
		<th class='ContestColumn'>Gara</th>
		<th class='DateColumn'>Data</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contests as $con) {
			?>
			<tr class='trlink' onclick="Redirect('ViewContestInformation', {ContestId:<?=$con['id']?>})">
			<td class='ContestColumn'><?=$con['name']?></td>
			<?php if (!is_null($con['date'])) { ?> <td class='DateColumn'><?=GetItalianDate($con['date'])?></td> <?php }
			else {?> <td class='DateColumn'>-</td> <?php } ?>
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
