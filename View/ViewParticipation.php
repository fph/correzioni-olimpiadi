<?php
global $v_corrections, $v_contestant, $v_contest;
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

<h3 class="PageSubtitle">
	<span class='contestant_title'>
		<?=$v_contestant['surname']?> <?=$v_contestant['name']?>
	</span>
</h3>

<?php
$columns=[];
$columns[]=['id'=>'problem','name'=>'Problema','class'=>['ProblemColumn'],'order'=>1];
$columns[]=['id'=>'mark','name'=>'Voto','class'=>['MarkColumn'],'order'=>1];
$columns[]=['id'=>'comment','name'=>'Commento','class'=>['CommentColumn']];
$columns[]=['id'=>'user','name'=>'Correttore','class'=>['UsernameColumn']];

$rows=[];
foreach($v_corrections as $correction) {
	$row=['values'=>[
		'problem'=>$correction['problem']['name'],
		'mark'=>$correction['mark'],
		'comment'=>$correction['comment'],
		'user'=>$correction['username']
		], 'data'=>['problem_id'=>$correction['problem']['id'] ] ];
	$rows[]=$row;
}

$table=['columns'=>$columns, 'rows'=>$rows ];
if( $v_contest['blocked']==0 ) {
	$images=[];
	$images[]=['name'=>'modify', 'onclick'=>'OnModification'];
	$images[]=['name'=>'confirm', 'onclick'=>'Confirm', 'hidden'=>1];
	$images[]=['name'=>'cancel', 'onclick'=>'Clear', 'hidden'=>1];
	$table['buttons']=$images;
}

InsertTable($table);
?>

<!-- Fare uno stile decente per questo linkino del cazzo -->
<a href="ViewParticipationTxt.php?ContestId=<?=$v_contest['id']?>&ContestantId=<?=$v_contestant['id']?>">Verbale di correzione</a>

<script>
	var ContestantId=<?=$v_contestant['id']?>;
	
	function GetContestantId(row){
		return ContestantId;
	}
	
	function GetProblemId(row) {
		return GetDataAttribute(row, "problem_id");
	}
</script>
