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

$columns=[];
$columns[]=['id'=>'username', 'name'=>'Correttore', 'class'=>['UsernameColumn'], 'order'=>1];

$rows=[];
foreach($v_users as $user) {
	$row=[
	'values'=>['username'=>$user['username']], 
	'redirect'=>['UserId'=>$user['id'] ] ];
	$rows[]=$row;
} 

$table=['columns'=>$columns, 'rows'=>$rows, 'redirect'=>'AdminUserInformation'];

InsertTable( $table );
?>

<h3 class="PageSubtitle">
	Aggiungi un correttore
</h3>

<div class='FormContainer'>
	<table>
	<tr>
		<th> Username </th>
		<th>Password</th>
		<th> </th>
	</tr>
	<tr>
		<td> <input type="text" name="username" id="UsernameInput"> </td>
		<td> <input type="text" name="password" id="PasswordInput"> </td>
		<td> <input type="button" value="Aggiungi" onclick=AddUserRequest()> </td>
	</tr>
	</table>
</div>
