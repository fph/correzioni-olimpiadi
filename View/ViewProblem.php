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
$columns[]=['id'=>'name','name'=>'Nome','class'=>['NameColumn'],'order'=>0];
$columns[]=['id'=>'mark','name'=>'Voto','class'=>['MarkColumn'],'order'=>1];
$columns[]=['id'=>'comment','name'=>'Commento','class'=>['CommentColumn'],'order'=>0];
$columns[]=['id'=>'user','name'=>'Correttore','class'=>['UsernameColumn'],'order'=>0];

$rows=[];
foreach($v_corrections as $correction) {
	$row=['values'=>[
		'surname'=>$correction['contestant']['surname'],
		'name'=>$correction['contestant']['name'],
		'mark'=>$correction['mark'],
		'comment'=>$correction['comment'],
		'user'=>$correction['username']
		], 'data'=>['contestant_id'=>$correction['contestant']['id'] ] ];
	$rows[]=$row;
}

$table=['columns'=>$columns, 'rows'=>$rows, 'redirect'=>['presence'=>0], 'buttons'=>['presence'=>0] ];
if( $v_contest['blocked']==0 ) {
	$table['buttons']['presence']=1;
	$images=[];
	$images[]=['name'=>'modify', 'onclick'=>'OnModification', 'hidden'=>0];
	$images[]=['name'=>'confirm', 'onclick'=>'Confirm', 'hidden'=>1];
	$images[]=['name'=>'cancel', 'onclick'=>'Clear', 'hidden'=>1];
	$table['buttons']['images']=$images;
}

InsertTable($table);
?>

<script>
	var ProblemId=<?=$v_problem['id']?>;
	
	
	function GetContestantId(element_this){
		return GetDataAttribute(element_this, "contestant_id");
	}
	
	function GetProblemId(element_this){
		return ProblemId;
	}
</script>
