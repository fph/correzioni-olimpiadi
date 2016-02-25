<?php
global $v_contest, $v_problem, $v_corrections;
?>

<h2 class='PageTitle'>
	<span> <?=$v_contest['name']?>
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
	<span>
		<?=$v_problem['name']?>
	</span>
</h3>

<?php
$columns = [];
$columns[] = ['id'=>'participant', 'name'=>'Partecipante', 'class'=>['SurnameAndNameColumn'], 'order'=>1];
$columns[] = ['id'=>'mark', 'name'=>'Voto', 'class'=>['MarkColumn'], 'order'=>1, 'type'=>'number'];
$columns[] = ['id'=>'comment', 'name'=>'Commento', 'class'=>['CommentColumn']];
$columns[] = ['id'=>'user', 'name'=>'Correttore', 'class'=>['UsernameColumn']];

$rows = [];
foreach ($v_corrections as $correction) {
	$FullName = $correction['contestant']['surname'] . ' ' . $correction['contestant']['name'];
	$ParticipantLink = '<a data-sort_name=\'' . $FullName. '\' 
						class=\'ContestantLink\' 
						href=\'ViewParticipation.php?ContestId='.$v_contest['id'] . 
						'&ContestantId='.$correction['contestant']['id'].'\'>';
	$row = ['values'=>[
		'participant'=>$ParticipantLink . $FullName . '</a>',
		'mark'=>($correction['mark']=='-1')?'∅':$correction['mark'],
		'comment'=>$correction['comment'],
		'user'=>$correction['username']
		], 'data'=>['contestant_id'=>$correction['contestant']['id'] ] ];
	$rows[] = $row;
}

$table = ['columns'=>$columns, 'rows'=>$rows, 'InitialOrder'=>['ColumnId'=>'participant'] ];
if ($v_contest['blocked'] == 0) {
	$buttons = [];
	$buttons['modify'] = ['onclick'=>'OnModification'];
	$buttons['confirm'] = ['onclick'=>'Confirm', 'hidden'=>true];
	$buttons['cancel'] = ['onclick'=>'Clear', 'hidden'=>true];
	$table['buttons'] = $buttons;
}

InsertDom('table', $table);
?>

<script>
	var ProblemId = <?=$v_problem['id']?>;
	
	
	function GetContestantId(row) {
		return GetDataAttribute(row, 'contestant_id');
	}
	
	function GetProblemId(row) {
		return ProblemId;
	}
</script>
