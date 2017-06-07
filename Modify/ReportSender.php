<?php
	require_once '../Utilities.php';
	SuperRequire_once('General', 'SessionManager.php');
	SuperRequire_once('General', 'sqlUtilities.php');
	SuperRequire_once('General', 'PermissionManager.php');
	SuperRequire_once('Modify', 'ObjectSender.php');

	function SendReport($db, $ContestId, $ContestantId, $accepted) {
		$contest = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
		$contestant = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$ContestantId]));
		if (is_null($contest)) {
			return ['type'=>'bad', 'text'=>'La gara selezionata non esiste'];
		}
		if (!$accepted and strlen($contest['NotAcceptedEmail']) == 0) {
			return ['type'=>'bad', 'text'=>'Per mandare l\'email personalizzata ai segati si deve impostare il contenuto della mail'];
		}
		if (is_null($contestant)) {
			return ['type'=>'bad', 'text'=>'Il partecipante selezionato non esiste'];
		}
		$participation = OneResultQuery($db, QuerySelect('Participations', ['ContestId'=>$ContestId, 'ContestantId'=>$ContestantId]));
		if (is_null($participation)) {
			return ['type'=>'bad', 'text'=>'Il partecipante selezionato non ha preso parte alla gara scelta'];
		}
		if (!is_string($contestant['email']) or !filter_var($contestant['email'], FILTER_VALIDATE_EMAIL)) {
			return ['type'=>'bad', 'text'=>'L\'indirizzo email del partecipante selezionato non è stato inserito oppure è malformato'];
		}
	
		$problems = ManyResultQuery($db, QuerySelect('Problems', ['ContestId'=>$ContestId]));

		usort($problems, BuildSorter('name'));

		$corrections = [];
		foreach ($problems as $prob) {
			$corr = OneResultQuery($db, QuerySelect('Corrections', 
				['ProblemId'=>$prob['id'], 'ContestantId'=>$ContestantId], 
				['mark', 'comment', 'UserId']
			));
			
			if (is_null($corr)) {
				$corr['done'] = false;
				$corr['mark'] = $corr['UserId'] = $corr['problem'] = $corr['username'] = null;
				$corr['comment'] = '';
			}
			else {
				$corr['done'] = true;
				$corr['username'] = OneResultQuery($db, QuerySelect('Users',
					['id'=>$corr['UserId']], ['username']
				))['username'];
			}
			$corr['problem'] = OneResultQuery($db, QuerySelect('Problems', ['id'=>$prob['id']]));
			
			$corrections[] = $corr;
		}

		$MailBody = 'Caro/a '.$contestant['name'].', <br>';

		if ($accepted) {
			$MailBody .= 'questo è il verbale di correzione dei tuoi esercizi: ';
		}
		else {
			// nl2br stands for newline to <br>
			$MailBody .= nl2br($contest['NotAcceptedEmail']);
		}
		$MailBody .= '<br><br>';

		foreach ($corrections as $correction) {
			$MailBody .= '<u>'.$correction['problem']['name'].'</u> ';
			if ($correction['done']) {
				$MailBody .= '<strong>'.(($correction['mark'] == '-1')?'∅':$correction['mark']).'</strong>';
				$MailBody .= ' [<kbd>'.$correction['username'].'</kbd>] '.$correction['comment'];
			} 
			else {
				$MailBody .= '<strong>#</strong>';
			}	
			$MailBody .= '<br>';
		}
		$MailBody .= '<br> p.s. Questa mail è stata inviata in automatico, <u>non rispondete a questo indirizzo</u> poiché nessuno leggerebbe la risposta.';
		
		$SendingSuccess = SendMail($contestant['email'], 'Verbale di correzione - Ammissione a '.$contest['name'], $MailBody);
		
		if (!$SendingSuccess) {
			return ['type'=>'bad', 'text'=>'L\'email non è stata inviata a causa di un errore del server'];
		}
		
		//~ Set the email field to true (even if it was already)
		Query($db, QueryUpdate('Participations', ['id'=>$participation['id']], ['email'=>1]));
		
		if ($participation['email'] == 0) return ['type'=>'good', 'text'=>'Email inviata con successo'];
		else return ['type'=>'good', 'text'=>'Email reinviata con successo'];
	}

	$db= OpenDbConnection();
	if (IsAdmin($db, GetUserIdBySession()) == 0) {
		$db -> close();
		SendObject(['type'=>'bad', 'text'=>'Non hai i permessi per mandare l\'email']);
		die();
	}
	
	$data = json_decode($_POST['data'], 1);
	
	SendObject(SendReport($db, $data['ContestId'], $data['ContestantId'], $data['accepted']));
	$db->close();
