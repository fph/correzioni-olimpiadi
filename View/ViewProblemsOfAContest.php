<?php
global $v_contest, $v_problems;
?>

<h2 class='PageTitle'>
	<span> <?=$v_contest['name']?>
	</span>
	<span>
	<?php 
	if (!is_null($v_contest['date'])) {?>
		- <?=GetItalianDate($v_contest['date'])?>
		<?php
	} ?>
	</span>
</h2>

<?php
if (empty($v_problems)) {
	?>
	<div class='EmptyTable'> Ancora nessun problema inserito. </div>
	<?php
}
else {
?>

<table class="InformationTable">
	<thead><tr>
		<th class='problem_column'>Problemi</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_problems as $pro) {
			?>
			<tr class='trlink' onclick="Redirect('ViewProblem', {ProblemId:<?=$pro['id']?>})">
			<td class='problem_column'><?=$pro['name']?></td>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<?php
}
?>
