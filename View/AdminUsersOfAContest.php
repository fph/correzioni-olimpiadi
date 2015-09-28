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
$columns = [];
$columns[]=['id'=>'username', 'name'=>'Correttore', 'class'=>['UsernameColumn'], 'order'=>1];

$rows = [];
foreach ($v_users as $user) {
	$row = [
	'values'=>['username'=>$user['username'] ],
	'data'=>['user_id'=>$user['id']] ];
	if ($user['role'] != 0) $row['class']=['NoTrashButton'];
	$rows[]=$row;
}

$buttons = ['trash'=>['onclick'=>'RemovePermissionRequest']];

$table = ['columns'=>$columns, 'rows'=>$rows, 'buttons'=>$buttons, 'id'=>'AdminUsersOfAContestTable', 'InitialOrder'=>['ColumnId'=>'username'] ];

InsertDom('table',  $table);
?>

<h3 class='PageSubtitle'>
	Aggiungi un correttore
</h3>

<?php
$form = ['SubmitText'=>'Aggiungi', 'SubmitFunction'=>'AddPermissionRequest(this.elements)', 'inputs'=>[
	['type'=>'AjaxSelect', 'title'=>'Username', 'select'=>['id'=>'UserInput', 'type'=>'user', 'name'=>'UserId']]
]];

InsertDom('form', $form);
?>

<script>
	var ContestId = <?=$v_contest['id']?>;
</script>
