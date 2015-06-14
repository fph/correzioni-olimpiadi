<?php
	require_once '../Utilities.php';
	SuperRequire_once('General', 'SessionManager.php');
	SuperRequire_once('General', 'sqlUtilities.php');
	SuperRequire_once('General', 'PermissionManager.php');
	SuperRequire_once('Modify', 'ObjectSender.php');

	function SendMail($db, $ContestId, $ContestantId) {
		$contest = OneResultQuery($db, QuerySelect('Contests', ['id'=>$ContestId]));
		$contestant = OneResultQuery($db, QuerySelect('Contestants', ['id'=>$ContestantId]));
		if (is_null($contest)) {
			return ['type'=>'bad', 'text'=>'La gara selezionata non esiste'];
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
		
		foreach ($problems as $pro) {
			$nn = OneResultQuery($db, QuerySelect('Corrections', 
			['ProblemId'=>$pro['id'], 'ContestantId'=>$ContestantId], 
			['mark', 'comment', 'UserId']
			));
			
			if (is_null($nn)) {
				$nn['done'] = false;
				$nn['mark'] = $nn['UserId']=$nn['problem']=$nn['username']=null;
				$nn['comment'] = '';
			}
			else {
				$nn['done'] = true;
				$nn['username'] = OneResultQuery($db, QuerySelect('Users', ['id'=>$nn['UserId']], ['username']))['username'];
			}
			$nn['problem'] = OneResultQuery($db, QuerySelect('Problems', ['id'=>$pro['id']]));
			
			$corrections[] = $nn;
		}
		
		$MailText = 'Caro/a '.$contestant['name'].', <br>questo è il verbale di correzione dei tuoi esercizi: <br><br>';
		foreach ($corrections as $correction) {
			$MailText .= '<u>'.$correction['problem']['name'].'</u> ';
			if ($correction['done']) {
				$MailText .= '<strong>'.$correction['mark'].'</strong>'.' [<kbd>'.$correction['username'].'</kbd>] '.$correction['comment'];
			} 
			else {
				$MailText .= '<strong>#</strong>';
			}	
			$MailText .= '<br>';
		}
		$MailText .= '<br> p.s. Questa mail è stata inviata in automatico, <u>non rispondete a questo indirizzo</u> poiché nessuno leggerebbe la risposta.';
		
		$MailObject = 'Verbale di correzione - Ammissione a '.$contest['name'];
		
		$MailHeaders = 'MIME-Version: 1.0'."\r\n";
		$MailHeaders .= 'Content-Type: text/html; charset=UTF-8'."\r\n";
		$MailHeaders .= 'From: '.EmailAddress."\r\n";
    
		$MailSent = mail($contestant['email'], $MailObject, $MailText, $MailHeaders);
		
		if ($MailSent == false) {
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
	
	SendObject(SendMail($db, $data['ContestId'], $data['ContestantId']));
	$db->close();
