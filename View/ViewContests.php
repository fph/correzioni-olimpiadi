<?php
global $v_contests;
?>

<h2 class="PageTitle">
	Lista delle gare
</h2>

<?php
	$columns=[];
	$columns[]= ['id'=>'name', 'name'=>'Gare', 'order'=>1, 'class'=>['contest_column']];
	$columns[]= ['id'=>'blocked', 'name'=>'', 'order'=>0, 'class'=>['CorrectionsCompleted']];
	$columns[]= ['id'=>'date', 'name'=>'Data', 'order'=>1, 'class'=>['date_column']];
	
	$rows=[];
	foreach( $v_contests as $contest ) {
		$row=['redirect'=>['ContestId'=>$contest['id']], 'values'=>[
			'name'=> $contest['name'], 'blocked'=>'', 'date'=>GetItalianDate($contest['date'])]
		];
		if( $contest['blocked']==1 ) $row['values']['blocked'] = 'Correzioni terminate';
		$rows[]=$row;
	}
	$Table=['columns'=>$columns, 'rows'=> $rows, 'redirect'=> ['presence'=>1, 'url'=>'ViewContestInformation'], 'buttons'=> ['presence'=>0]];
	InsertTable( $Table );
?>
