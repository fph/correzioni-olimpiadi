<?php
global $v_contest, $v_problems, $v_contestants;
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
		$rows[]=['values'=>$values];
	}
	
	$table=['columns'=>$columns, 'rows'=>$rows, 'id'=> 'ContestRankingTable', 'InitialOrder'=>['ColumnId'=>'score', 'ascending'=>1] ];
	InsertTable($table);
	
?>
