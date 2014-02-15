<?php
global $v_contests;
?>

<script>
	function Redirect(contestId) {
		document.location="ViewContestInformation.php?contestId="+contestId;
	}
</script>

<h2 class="pageTitle">
	Tutte le gare
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
			<tr class='trlink' onclick=Redirect(<?=$con['id']?>)>
			<td class='contestColumn'><?=$con['name']?></td>
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
