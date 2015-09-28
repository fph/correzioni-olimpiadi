<?php
global $v_users;
?>

<h2 class='PageTitle'>
	Amministrazione
</h2>

<h3 class='PageSubtitle'>
	Correttori
</h3>

<?php

$columns = [];
$columns[]=['id'=>'username', 'name'=>'Correttore', 'class'=>['UsernameColumn'], 'order'=>1];

$rows = [];
foreach ($v_users as $user) {
	$row = [
	'values'=>['username'=>$user['username']], 
	'redirect'=>['UserId'=>$user['id'] ] ];
	$rows[]=$row;
} 

$table = ['columns'=>$columns, 'rows'=>$rows, 'redirect'=>'AdminUserInformation', 'id'=>'AdminUsersTable', 'InitialOrder'=>['ColumnId'=>'username'] ];

InsertDom('table',  $table);
?>

<h3 class='PageSubtitle'>
	Aggiungi un correttore
</h3>

<?php
$form = ['SubmitText'=>'Aggiungi', 'SubmitFunction'=>'AddUserRequest(this.elements)', 'inputs'=>[
	['type'=>'text', 'title'=>'Username', 'name'=>'username'],
	['type'=>'text', 'title'=>'Password', 'name'=>'password']
]];
InsertDom('form', $form);
?>
