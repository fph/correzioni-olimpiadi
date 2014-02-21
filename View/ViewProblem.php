<?php
global $v_contest, $v_problem, $v_corrections;
?>


<h2 class='PageTitle'>
	<span class='contest_title'> <?=$v_contest['name']?>
	</span>
	<span class='date_title'>
	<?php 
	if (!is_null($v_contest['date'])) {?>
		- <?=GetItalianDate($v_contest['date'])?>
		<?php
	} ?>
	</span>
</h2>

<h3 class='PageSubtitle' id='<?=$v_problem['id']?>'>
	<span class='problem_title'>
		<?=$v_problem['name']?>
	</span>
</h3>

<?php
if (empty($v_corrections)) {
	?>
	<div class='EmptyTable'> Ancora nessuna correzione. </div>
	<?php
}
else {
?>

<table class="InformationTable">
	<thead><tr>
		<th class='surname_column'>Cognome</th>
		<th class='name_column'>Nome</th>
		<th class='mark_column'>Voto</th>
		<th class='comment_column'>Commento</th>
		<th class='username_column'>Correttore</th>
		<?php
			if (!$v_contest['blocked']) {
			?>
			<th class='modify_column'></th>
			<th class='cancel_column'></th>
			<?php
		}?>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_corrections as $cor) {
			?>
			<tr data-contestant_id='<?=$cor['contestant']['id']?>'>
			<td class='surname_column'><?=$cor['contestant']['surname']?></td>
			<td class='name_column'><?=$cor['contestant']['name']?></td>
			<?php
			if ($cor['done']) {
				?>
				<td class='mark_column'><?=$cor['mark']?></td>
				<td class='comment_column'><?=$cor['comment']?></td>
				<td class='username_column'><?=$cor['username']?></td>
				<?php 
			}
			else {
				?>
				<td class='mark_column'>-</td><td class='comment_column'>-</td><td class='username_column'>-</td>
				<?php
			} ?>
				
			<?php
			if (!$v_contest['blocked']) {
				?>
				<td class='modify_column'> <div class='ButtonContainer'>
				<img class='modify_button_image ButtonImage' src='../View/Images/modify_button_image.png' alt='Modifica' onclick=OnModification(this)>
				</div> </td>
				<td class='cancel_column'> <div class='ButtonContainer'> </div> </td>
				<?php
			}?>
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
	var ProblemId=<?=$v_problem['id']?>;
	
	
	function GetContestantId(element_this){
		return GetDataAttribute(element_this, "contestant_id");
	}
	
	function GetProblemId(element_this){
		return ProblemId;
	}
</script>
