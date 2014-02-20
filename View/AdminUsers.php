<?php
global $v_users;
?>

<h2 class='PageTitle'>
	Correttori
</h2>

<h3 class='PageSubtitle'>
	Lista dei correttori
</h3>

<?php
if (empty($v_users)) {
	?>
	<div class='EmptyTable'> Ancora nessun correttore inserito. </div>
	<table class='InformationTable HiddenEmptyTable'>
	<?php
}
else {
?>
	<table class='InformationTable'>
	<?php
}?>
	<thead><tr>
		<th class='username_column'>Username</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_users as $use) {
			?>
			<tr class='trlink' data-orderby='<?=$use['username']?>' onclick=Redirect('AdminUserInformation',{UserId:<?=$use['id']?>})>
			<td class='username_column'><?=$use['username']?></td>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<h3 class="PageSubtitle">
	Aggiungi un correttore
</h3>

<div class='createContainer'>
	<table>
	<tr>
		<th> Username </th>
		<th>Password</th>
		<th> </th>
	</tr>
	<tr>
		<td> <input type="text" name="username" id="username_input"> </td>
		<td> <input type="text" name="password" id="password_input"> </td>
		<td> <input type="button" value="Aggiungi" onclick=AddUserRequest()> </td>
	</tr>
	</table>
</div>
