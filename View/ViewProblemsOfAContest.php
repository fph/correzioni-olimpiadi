<?php
global $v_contest, $v_problems;
?>

<h2 class='pageTitle'>
	<span class='contest_title'> <?=$v_contest['name']?>
	</span>
	<span class='date_title'>
	<?php 
	if (!is_null($v_contest['date'])) {?>
		- <?=getItalianDate($v_contest['date'])?>
		<?php
	} ?>
	</span>
</h2>

<?php
if (empty($v_problems)) {
	?>
	<div class='emptyTable'> Ancora nessun problema inserito. </div>
	<?php
}
else {
?>

<table class="InformationTable" id="problemsOfAContestTable">
	<thead><tr>
		<th class='problemColumn'>Problemi</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_problems as $pro) {
			?>
			<tr class='trlink' onclick="Redirect('ViewProblem', {problemId:<?=$pro['id']?>})">
			<td class='problemColumn'><?=$pro['name']?></td>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<?php
}
?>
