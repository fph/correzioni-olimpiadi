<?php
global $v_users;
?>

<h2 class='pageTitle'>
	Correttori
</h2>

<h3 class='pageSubtitle'>
	Lista dei correttori
</h3>

<?php
if (empty($v_users)) {
	?>
	<div class='emptyTable'> Ancora nessun correttore inserito. </div>
	<?php
}
else {
?>

<table class='InformationTable'>
	<thead><tr>
		<th class='usernameColumn'>Username</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_users as $use) {
			?>
			<tr class='trlink' onclick=Redirect('AdminUserInformation',{userId:<?=$use['id']?>})>
			<td class='usernameColumn'><?=$use['username']?></td>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<?php
}
?>

<h3 class="pageSubtitle">
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
