<?php
	require_once '../Utilities.php';
	SuperRequire_once('General', 'SessionManager.php');
	SuperRequire_once('General', 'sqlUtilities.php');
	SuperRequire_once('General', 'PermissionManager.php');
	SuperRequire_once('Modify', 'ObjectSender.php');

	function MultipleRanking($db, $list) {//Returns the table containing weighted result (using list[i]['ContestId'] and list[i]['weight'])
		//This first part makes query to db and keeps information in: 
		// $contests as an array (an element has id, name, weight, problems array)
		// AllContestant= associative array AllContestants[ContestantId] has id, surname, name, marks=associative array (ProblemId=>mark)
		
		//~ TODO: Si dà per scontato che i dati passati dall'utente siano ben formati (non è una falla di sicurezza, ma potrebbe generare warning)
		$ContestNumber = count($list);
		$contests = [];
		$AllContestants = [];
		for ($i=0; $i<$ContestNumber; $i++) {
			$input = $list[$i];
			$id = $input['ContestId'];
			if (!is_numeric($input['weight']) or $input['weight']<0 or $input['weight']>100) {
				return ['type'=>'bad', 'text'=>'Il peso di una gara deve essere un numero positivo tra 0 e 100'];
			}
			$contest = OneResultQuery($db, QuerySelect('Contests', ['id'=>$id]));
			if (is_null($contest)) {
				return ['type'=>'bad', 'text'=>'Una delle gare scelte non esiste'];
			}
			$contest['weight']=$input['weight'];
			
			$ContestParticipations = ManyResultQuery($db, QuerySelect('Participations', ['ContestId'=>$id]));
			foreach ($ContestParticipations as $participation) {
				$ContestantId = $participation['ContestantId'];
				if (!isset($AllContestants[$ContestantId])) {
					$contestant = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$ContestantId]));
					$AllContestants[$ContestantId]=$contestant;
				}
			}
			
			$contest['problems']=ManyResultQuery($db, QuerySelect('Problems', ['ContestId'=>$id]));
			usort($contest['problems'], BuildSorter('name'));
			$ProbNum = count($contest['problems']);
			
			for ($j=0; $j<$ProbNum; $j++) {
				$ProblemId = $contest['problems'][$j]['id'];
				$ProblemCorrections = ManyResultQuery($db, QuerySelect('Corrections', ['ProblemId'=>$ProblemId], ['mark', 'ContestantId']));
				foreach ($ProblemCorrections as $correction) {
					$AllContestants[$correction['ContestantId']]['marks'][$ProblemId]=$correction['mark'];
				}
			}
			
			$contests[]=$contest;
		}
		
		//Here I build the table using only $contests and $AllContestants
		$columns = [];
		$columns[]=['id'=>'contestant', 'name'=>'Partecipante', 'class'=>['SurnameAndNameColumn'], 'order'=>1, 'type'=>'string'];
		foreach ($contests as $contest) {
			foreach ($contest['problems'] as $problem) {
				$columns[]=['id'=>'Problem'.strval($problem['id']), 'name'=>$problem['name'], 'class'=>['MarkColumn'], 'order'=>1, 'type'=>'number'];
			}
			$columns[]=['id'=>'Contest'.strval($contest['id']), 'name'=>$contest['name'], 'class'=>['MarkColumn', 'ContestScoreColumn'], 'order'=>1, 'type'=>'number'];
		}
		$columns[]=['id'=>'score', 'name'=>'Punteggio', 'class'=>['MarkColumn', 'ScoreColumn'], 'order'=>1, 'type'=>'number'];
		
		$rows = [];
		foreach ($AllContestants as $contestant) {
			$values = ['contestant'=>$contestant['surname'].' '.$contestant['name']];
			$total = 0;
			foreach ($contests as $contest) {
				$SubTotal = 0;
				foreach ($contest['problems'] as $problem) {
					if (isset($contestant['marks'][$problem['id']])) {
						$values['Problem'.$problem['id']]=$contestant['marks'][$problem['id']];
						$mark = $contestant['marks'][$problem['id']];
						$SubTotal += $mark;
					}
				}
				$values['Contest'.$contest['id']]=$SubTotal;
				$total += $SubTotal*$contest['weight'];
			}
			$values['score']=$total;
			$rows[]=['values'=>$values];
		}
		
		$table = ['columns'=>$columns, 'rows'=>$rows, 'id'=>'MultipleRankingTable', 'InitialOrder'=>['ColumnId'=>'score', 'ascending'=>1] ];
		
		$table['type']='good';
		$table['text']='Creato le statistiche con successo';
		return $table;
	}
	
	
	$db= OpenDbConnection();
	if (IsAdmin($db, GetUserIdBySession()) == 0) {
		$db -> close();
		SendObject(['type'=>'bad', 'text'=>'Non hai i permessi per vedere le statistiche']);
		die();
	}
	
	$data = json_decode($_POST['data'], 1);
	
	SendObject(MultipleRanking($db, $data));
?>
