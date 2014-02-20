<?php
global $v_contest, $v_problems;
?>

<h2 class='PageTitle'>
	<span class='contest_title'>
	<?=$v_contest['name']?>
	</span>
	<span class='date_title'>
	<?php 
	if (!is_null($v_contest['date'])) {?>
		- <?=GetItalianDate($v_contest['date'])?>
		<?php
	} ?>
	</span>
</h2>

<h3 class='PageSubtitle'>
	Lista dei problemi
</h3>

<?php
if (empty($v_problems)) {
	?>
	<div class='EmptyTable'> Ancora nessun problema inserito. </div>
	<table class='InformationTable HiddenEmptyTable'>
	<?php
}
else {
	?>
	<div class='EmptyTable HiddenEmptyTable'>Ancora nessun problema inserito. </div>
	<table class='InformationTable'>
	<?php
}?>
	<thead><tr>
		<th class='problem_column'>Problemi</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_problems as $pro) {
			?>
			<tr data-orderby='<?=$pro['name']?>' data-problem_id='<?=$pro['id']?>'>
			<td class='problem_column'><?=$pro['name']?></td>
			<td class='trash_column'> <div class='ButtonContainer'>
				<img class='ButtonImage' src='../View/Images/trash_button_image.png' alt='Elimina' onclick=RemoveProblemRequest(this)>
			</div> </td>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>


<h3 class='PageSubtitle'>
	Aggiungi un problema
</h3>

<div class='createContainer'>
	<table>
	<tr>
		<th> Nome </th>
		<th> </th>
	</tr>
	<tr>
		<td> <input type='text' name='name' id='name_input'> </td>
		<td> <input type='button' value='Aggiungi' onclick=AddProblemRequest()> </td>
	</tr>
	</table>
</div>


<script>
	var ContestId=<?=$v_contest['id']?>;

</script>
