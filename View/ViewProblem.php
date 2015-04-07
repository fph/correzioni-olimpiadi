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
$columns=[];
$columns[]=['id'=>'surname','name'=>'Cognome','class'=>['SurnameColumn'],'order'=>1];
$columns[]=['id'=>'name','name'=>'Nome','class'=>['NameColumn']];
$columns[]=['id'=>'mark','name'=>'Voto','class'=>['MarkColumn'],'order'=>1];
$columns[]=['id'=>'comment','name'=>'Commento','class'=>['CommentColumn']];
$columns[]=['id'=>'user','name'=>'Correttore','class'=>['UsernameColumn']];

$rows=[];
foreach($v_corrections as $correction) {
	$row=['values'=>[
		'surname'=>$correction['contestant']['surname'],
		'name'=>$correction['contestant']['name'],
		'mark'=> $correction['mark'],
		'comment'=> $correction['comment'],
		'user'=> $correction['username']
		], 'data'=>['contestant_id'=>$correction['contestant']['id'] ] ];
	$rows[]=$row;
}

$table=['columns'=>$columns, 'rows'=>$rows, 'InitialOrder'=>['ColumnId'=>'surname'] ];
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
	var ProblemId=<?=$v_problem['id']?>;
	
	
	function GetContestantId(row){
		return GetDataAttribute(row, 'contestant_id');
	}
	
	function GetProblemId(row){
		return ProblemId;
	}
</script>
