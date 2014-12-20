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
		'mark'=>( isset($correction['mark']) )? $correction['mark'] : null,
		'comment'=>( isset($correction['comment']) )? $correction['comment'] : null,
		'user'=>( isset($correction['username']) )? $correction['username'] : null
		], 'data'=>['contestant_id'=>$correction['contestant']['id'] ] ];
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

<script>
	var ProblemId=<?=$v_problem['id']?>;
	
	
	function GetContestantId(row){
		return GetDataAttribute(row, "contestant_id");
	}
	
	function GetProblemId(row){
		return ProblemId;
	}
</script>
