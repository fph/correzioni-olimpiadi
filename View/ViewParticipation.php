<?php
global $v_admin, $v_corrections, $v_contestant, $v_contest;
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
<!--
	TODO: Il bottone della mail dovrebbe essere visibile solo agli admin
-->
<h3 class="PageSubtitle">
	<span class='contestant_title'>
		<?=$v_contestant['surname']?> <?=$v_contestant['name']?> 
<?php	if( $v_admin==1 ) { ?>
			(<a id='CorrectionRecord' href="ViewParticipationTxt.php?ContestId=<?=$v_contest['id']?>&ContestantId=<?=$v_contestant['id']?>">verbale di correzione</a>
			<?php InsertDom('buttons', ['buttons'=>['SendMail'=>['onclick'=>'SendMail('.$v_contest['id'].', '.$v_contestant['id'].')']]]); ?>
			)
<?php   } ?>
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

$table=['columns'=>$columns, 'rows'=>$rows, 'InitialOrder'=>['ColumnId'=>'problem'] ];
if( $v_contest['blocked']==0 ) {
	$buttons=[];
	$buttons['modify']=['onclick'=>'OnModification'];
	$buttons['confirm']=['onclick'=>'Confirm', 'hidden'=>true];
	$buttons['cancel']=['onclick'=>'Clear', 'hidden'=>true];
	$table['buttons']=$buttons;
}

InsertDom( 'table', $table);
?>

<script>
	var ContestantId=<?=$v_contestant['id']?>;
	
	function GetContestantId(row){
		return ContestantId;
	}
	
	function GetProblemId(row) {
		return GetDataAttribute(row, "problem_id");
	}
</script>
