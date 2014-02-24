<?php
global $v_contest, $v_users;
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
	Lista dei correttori
</h3>

<?php
if (empty($v_users)) {
	?>
	<div class='EmptyTable'> Ancora nessun correttore inserito. </div>
	<table class='InformationTable hidden'>
	<?php
}
else {
?>
	<div class='EmptyTable hidden'> Ancora nessun correttore inserito. </div>
	<table class='InformationTable'>
	<?php
}?>
	<thead><tr>
		<th class='UsernameColumn'>Correttori</th>
		<th class='trash_column'></th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_users as $use) {
			?>
			<tr data-orderby='<?=$use['username']?>' data-user_id='<?=$use['id']?>'>
			<td class='UsernameColumn'><?=$use['username']?></td>
			<td class='trash_column'> <div class='ButtonContainer'>
				<?php
				if (!$use['admin']) {
					?>
					<img class='ButtonImage' src='../View/Images/TrashButton.png' alt='Elimina' onclick="RemovePermissionRequest(this)">
					<?php
				}?>
			</div> </td>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<h3 class='PageSubtitle'>
	Aggiungi un correttore
</h3>

<div class='FormContainer'>
	<table>
	<tr>
		<th> Username </th>
		<th> </th>
	</tr>
	<tr>
		<td> <input type='text' name='username' id='UsernameInput'> </td>
		<td> <input type='button' value='Aggiungi' onclick="AddPermissionRequest()"> </td>
	</tr>
	</table>
</div>

<script>
	var ContestId=<?=$v_contest['id']?>;
</script>