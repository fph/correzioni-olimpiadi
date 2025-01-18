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
	$columns = [];
	$columns[] = ['id'=>'contestant', 'name'=>'Partecipante', 'class'=>['SurnameAndNameColumn'], 'order'=>1, 'type'=>'string'];
	
	usort($v_problems, BuildSorter('name'));
	foreach ($v_problems as $problem) {
		$columns[] = ['id'=>strval($problem['id']), 'name'=>$problem['name'], 'class'=>['MarkColumn'], 'order'=>1, 'type'=>'number'];
	}
	$columns[] = ['id'=>'score', 'name'=>'Punteggio', 'class'=>['MarkColumn'], 'order'=>1, 'type'=>'number'];
	$columns[] = ['id'=>'LastYear', 'name'=>'Ultimo Anno', 'class'=>['LastYearColumn'], 'order'=>1, 'type'=>'number'];
	$columns[] = ['id'=>'PastCamps', 'name'=>'Pise', 'class'=>['PastCampsColumn'], 'order'=>1, 'type'=>'number'];
	
	$rows = [];
	foreach ($v_contestants as $contestant) {
		$values = ['contestant'=>$contestant['surname'].' '.$contestant['name']];
		$total = 0;
		foreach ($v_problems as $problem) {
			if (isset($contestant['marks'][$problem['id']])) {
				$mark = $contestant['marks'][$problem['id']];
				$values[$problem['id']] = ($mark == '-1')?'∅':$mark;
				$total += ($mark == '-1')?0:$mark;
			}
		}
		$values['score'] = $total;
		$values['LastYear'] = $contestant['LastOlympicYear'];
		$values['PastCamps'] = $contestant['PastCamps'];
		
		$row = [
			'values'=>$values,
			'redirect'=>['ContestId'=>$v_contest['id'], 'ContestantId'=>$contestant['id'] ],
			'data'=>['ContestantId'=>$contestant['id']]
		];
		if ($contestant['email'] == 1) $row['class']=['ContestantWithRemail'];
		
		$rows[] = $row;
	}
	
	$buttons = null;
	if ($v_admin == 1) {
		$buttons = ['GoodMail'=>['onclick'=>'SendGoodMail'], 'BadMail'=>['onclick'=>'SendBadMail']];
	}
	
	$table = ['columns'=>$columns, 'rows'=>$rows, 'redirect'=>'ViewParticipation', 'id'=> 'ContestRankingTable', 'InitialOrder'=>['ColumnId'=>'score', 'ascending'=>1], 'LineNumbers'=>true, 'buttons'=>$buttons ];
	InsertDom('table', $table);
?>

<script>
	var ContestId = <?=$v_contest['id']?>;
</script>
