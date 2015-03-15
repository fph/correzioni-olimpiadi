<?php
global $v_admin, $v_contest, $v_problems, $v_contestants;
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
	Classifica
</h3>

<?php
	$columns=[];
	$columns[]=['id'=>'contestant', 'name'=>'Partecipante', 'class'=>['SurnameAndNameColumn'], 'order'=>1, 'type'=>'string'];
	
	usort($v_problems, BuildSorter('name'));
	foreach($v_problems as $problem) {
		$columns[]=['id'=>strval( $problem['id']), 'name'=>$problem['name'], 'class'=>['MarkColumn'], 'order'=>1, 'type'=>'number'];
	}
	$columns[]=['id'=>'score', 'name'=>'Punteggio', 'class'=>['MarkColumn'], 'order'=>1, 'type'=>'number']; 
	
	$rows=[];
	foreach( $v_contestants as $contestant ) {
		$values=['contestant'=>$contestant['surname'].' '.$contestant['name']];
		$total=0;
		foreach( $v_problems as $problem ) {
			if( isset( $contestant['marks'][$problem['id']] ) ) {
				$values[$problem['id']]=$contestant['marks'][$problem['id']];
				$total+=intval($contestant['marks'][$problem['id']]);
			}
		}
		$values['score']=$total;
		
		$row=[
			'values'=>$values,
			'redirect'=>['ContestId'=>$v_contest['id'], 'ContestantId'=>$contestant['id'] ],
			'data'=>['ContestantId'=>$contestant['id']]
		];
		if( $contestant['email']==1 ) $row['class']=['ContestantWithRemail'];
		
		$rows[]=$row;
	}
	
	$buttons=null;
	if( $v_admin==1 ) $buttons=['mail'=>['onclick'=>'SendMail']];
	
	$table=['columns'=>$columns, 'rows'=>$rows, 'redirect'=>'ViewParticipation', 'id'=> 'ContestRankingTable', 'InitialOrder'=>['ColumnId'=>'score', 'ascending'=>1], 'buttons'=>$buttons ];
	InsertDom( 'table', $table);
?>

<script>
	var ContestId=<?=$v_contest['id']?>;
</script>
