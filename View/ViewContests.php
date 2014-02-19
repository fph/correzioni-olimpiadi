<?php
global $v_contests;
?>

<h2 class="pageTitle">
	Lista delle gare
</h2>

<?php
if (empty($v_contests)) {
	?>
	<div class='emptyTable'> Ancora nessuna gara inserita. </div>
	<?php
}
else {
?>

<table class="InformationTable">
	<thead><tr>
		<th class='contestColumn'>Gare</th>
		<th class='dateColumn'>Data</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contests as $con) {
			?>
			<tr class='trlink' onclick="Redirect('ViewContestInformation', {contestId:<?=$con['id']?>})">
			<td class='contestColumn'><?=$con['name']?>
			
			<span class='blocked correctionsCompleted' >
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
				<td class='dateColumn'><?=getItalianDate($con['date'])?></td> 
				<?php 
			}
			else { 
				?>
				<td class='dateColumn'>-</td> 
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
