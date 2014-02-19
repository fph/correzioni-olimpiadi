<?php
global $v_contest, $v_problems;
?>

<h2 class='pageTitle' value='<?=$v_contest['id']?>'>
	<span class='contest_title'>
	<?=$v_contest['name']?>
	</span>
	<span class='date_title'>
	<?php 
	if (!is_null($v_contest['date'])) {?>
		- <?=getItalianDate($v_contest['date'])?>
		<?php
	} ?>
	</span>
</h2>

<h3 class='pageSubtitle'>
	Lista dei problemi
</h3>

<?php
if (empty($v_problems)) {
	?>
	<div class='emptyTable'> Ancora nessun problema inserito. </div>
	<table class="InformationTable hiddenEmptyTable">
	<?php
}
else {
	?>
	<table class="InformationTable">
	<?php
}?>
	<thead><tr>
		<th class='problemColumn'>Problemi</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_problems as $pro) {
			?>
			<tr class='trlink' value='<?=$pro['name']?>' onclick="Redirect()">
			<td class='problemColumn'><?=$pro['name']?></td>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>


<h3 class="pageSubtitle">
	Aggiungi un problema
</h3>

<div class='createContainer'>
	<table>
	<tr>
		<th> Nome </th>
		<th> </th>
	</tr>
	<tr>
		<td> <input type="text" name="name" id="name_input"> </td>
		<td> <input type="button" value="Aggiungi" onclick=AddProblemRequest()> </td>
	</tr>
	</table>
</div>
