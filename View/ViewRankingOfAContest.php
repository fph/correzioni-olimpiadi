<?php
global $v_contest, $v_problems, $v_contestants;
?>

<h2 class='PageTitle'>
	Classifica
</h2>
<h3 class='PageSubtitle'>
	<?=$v_contest['name']?>
</h3>

<?php
	$columns=[];
	$columns[]=['id'=>'contestant', 'name'=>'Partecipante', 'class'=>['SurnameAndNameColumn'], 'order'=>1, 'type'=>'string'];
	
	usort($v_problems, build_sorter('name'));
	foreach($v_problems as $problem) {
		$columns[]=['id'=>strval( $problem['id']), 'name'=>$problem['name'], 'class'=>['ProblemColumn'], 'order'=>1, 'type'=>'number'];
	}
	$columns[]=['id'=>'score', 'name'=>'Punteggio', 'class'=>['ScoreColumn'], 'order'=>1, 'type'=>'number']; 
	
	$rows=[];
	foreach( $v_contestants as $contestant ) {
		$values=['contestant'=>$contestant['surname'].' '.$contestant['name']];
		$total=0;
		foreach( $v_problems as $problem ) {
			if( !is_null( $contestant['marks'][$problem['id']] ) ) {
				$values[$problem['id']]=$contestant['marks'][$problem['id']];
				$total+=intval($contestant['marks'][$problem['id']]);
			}
		}
		$values['score']=$total;
		$rows[]=['values'=>$values];
	}
	
	$table=['columns'=>$columns, 'rows'=>$rows, 'id'=> 'ContestRankingTable', 'InitialOrder'=>['ColumnId'=>'score', 'ascending'=>1] ];
	InsertTable($table);
	
?>
