<?php
global $v_user, $v_contests, $v_role;
?>

<h2 class='PageTitle'>
	<span id='UsernameTitle'><?=$v_user['username']?></span>
	
	<?php
	if ($v_user['role'] == 0) InsertDom('buttons', ['title'=>true]);
	?>
		
</h2>
<?php
$UserRoleValue = 'user';
$UserRoleText = 'Correttore';
if ($v_user['role'] == 1) {
	$UserRoleValue = 'admin';
	$UserRoleText = 'Amministratore';
}
else if ($v_user['role'] == 2) {
	$UserRoleValue = 'SuperAdmin';
	$UserRoleText = 'Super amministratore';
}
?>
<div class='GeneralInformation'>
	<div id='UserRoleContainer' data-value='<?=$UserRoleValue?>'>
		<span id='UserRoleSpan' class='UserRole'>
			<?=$UserRoleText?>
		</span>

<?php
if ($v_role == 2 and $v_user['role'] != 2) {
?> 
		<select id='UserRoleSelect' class='hidden'>
			<option value='user'>Correttore</option>
			<option value='admin'>Amministratore</option>
			<option value='SuperAdmin'>Super amministratore</option>
		</select>
	
<?php
	$buttons = ['class'=> ['ButtonsSubtitle'], 'buttons'=>[
		'modify'=>['onclick'=>'ModifyUserRole()'], 
		'confirm'=>['onclick'=>'ConfirmUserRole()', 'hidden'=>true], 
		'cancel'=>['onclick'=>'CancelUserRole()', 'hidden'=>true]
	]];
	InsertDom('buttons', $buttons);
}
?>
	</div>
</div>

<?php
$columns = [];
$columns[]=['id'=>'contest', 'name'=>'Gara', 'class'=>['ContestColumn'], 'order'=>1, 'type'=>'string'];
$columns[]=['id'=>'date', 'name'=>'Data', 'class'=>['DateColumn'], 'order'=>1, 'type'=>'date'];

$rows = [];
foreach ($v_contests as $contest) {
	$row = [
	'values'=>['contest'=>$contest['name'], 'date'=>$contest['date']], 
	'redirect'=>['ContestId'=>$contest['id'] ] ];
	$rows[]=$row;
} 

$table = ['columns'=>$columns, 'rows'=>$rows, 'redirect'=>'ViewContestInformation', 'InitialOrder'=>['ColumnId'=>'date']];

InsertDom('table',  $table);
?>

<?php
if ($v_user['role'] == 0) {
?>
<h3 class="PageSubtitle">
	Reimposta la password
</h3>

<div class='FormContainer'>
	<table>
	<tr>
		<th> Nuova password </th>
		<th> </th>
	</tr>
	<tr>
		<td> <input type='text' name='NewPassword' id='NewPasswordInput'> </td>
		<td> <input type='button' value='Reimposta' onclick='ChangePasswordRequest()'> </td>
	</tr>
	</table>
</div>
<?php
}
?>

<script>
	var UserId = <?=$v_user['id']?>;
</script>
