<?php
global $v_contests;
?>

<h2 class="PageTitle">
	Lista delle gare
</h2>

<?php
if (empty($v_contests)) {
	?>
	<div class='EmptyTable'> Ancora nessuna gara inserita. </div>
	<?php
}
else {
?>

<table class="InformationTable">
	<thead><tr>
		<th class='contest_column'>Gare</th>
		<th class='date_column'>Data</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contests as $con) {
			?>
			<tr class='trlink' onclick="Redirect('ViewContestInformation', {ContestId:<?=$con['id']?>})">
			<td class='contestColumn'><?=$con['name']?>
			
			<span class='blocked CorrectionsCompleted' >
			<?php
			if ($con['blocked']==1) {
				?>
				Correzioni terminate
				<?php
			}?>
			</span>
			</td>
			<?php if (!is_null($con['date'])) { 
				?> 
				<td class='date_column'><?=GetItalianDate($con['date'])?></td> 
				<?php 
			}
			else { 
				?>
				<td class='date_column'>-</td> 
				<?php 
			} ?>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<?php
}
?>
