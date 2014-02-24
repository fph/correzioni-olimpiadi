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
$columns=[];
$columns[]=['id'=>'username', 'name'=>'Correttore', 'class'=>['UsernameColumn'], 'order'=>1];

$rows=[];
foreach($v_users as $user) {
	$row=[
	'values'=>['username'=>$user['username'] ],
	'data'=>['user_id'=>$user['id']] ];
	if( $user['admin'] ) $row['class']=['NoTrashButton'];
	$rows[]=$row;
}

$buttons=[];
$buttons[]=['name'=>'trash', 'onclick'=>'RemovePermissionRequest'];

$table=['columns'=>$columns, 'rows'=>$rows, 'buttons'=>$buttons, 'id'=>'AdminUsersOfAContestTable'];

InsertTable( $table );
?>

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
