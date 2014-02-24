<?php
global $v_contest, $v_problems;
?>

<h2 class='PageTitle'>
	<span>
	<?=$v_contest['name']?>
	</span>
	<span>
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
	<table class='InformationTable hidden'>
	<?php
}
else {
	?>
	<div class='EmptyTable hidden'>Ancora nessun problema inserito. </div>
	<table class='InformationTable'>
	<?php
}?>
	<thead><tr>
		<th class='ProblemColumn'>Problemi</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_problems as $pro) {
			?>
			<tr data-orderby='<?=$pro['name']?>' data-problem_id='<?=$pro['id']?>'>
			<td class='ProblemColumn'><?=$pro['name']?></td>
			<td class='modify_column'> <div class='ButtonContainer'>
				<img class='ModifyButtonImage ButtonImage' src='../View/Images/ModifyButton.png' alt='Modifica' onclick="OnModification(this)">
			</div> </td>
			<td class='trash_column'> <div class='ButtonContainer'>
				<img class='TrashButtonImage ButtonImage' src='../View/Images/TrashButton.png' alt='Elimina' onclick="RemoveProblemRequest(this)">
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

<div class='FormContainer'>
	<table>
	<tr>
		<th> Nome </th>
		<th> </th>
	</tr>
	<tr>
		<td> <input type='text' name='name' id='ProblemInput'> </td>
		<td> <input type='button' value='Aggiungi' onclick=AddProblemRequest()> </td>
	</tr>
	</table>
</div>


<script>
	var ContestId=<?=$v_contest['id']?>;

</script>
