<?php
	require_once '../Utilities.php';
	SuperRequire_once('General', 'sqlUtilities.php');
	require PHPMailerPath; // PhpMailer library
	SuperRequire_once('Modify', 'ObjectSender.php');

	function SendCode($db, $ContestantEmail) {
		// FIXME: The use of mt_rand is not secure
		$code = crypt($ContestantEmail, '$5$'.mt_rand(1000000, 9999999)); // SHA-256 hash
		$code = substr($code, 11, 7); // The first 11 chars are the seed
		$code = substr(base64_encode($code), 0, 6); // In order to have only alphanumeric chars
				
		$MailText = 'Il codice di verifica che devi inserire sul sito <strong>Correzioni Olimpiadi</strong> è:<br>';
		$MailText .= '<big>'.$code.'</big><br><br>';
		$MailText .= 'p.s. Se non hai richiesto l\'invio del codice di verifica, ignora questa email.';
		
		// Send mail
		$mail = new PHPMailer;
		$mail->CharSet = 'UTF-8';
		
		if (EmailSMTP) {
			$mail->isSMTP();
			$mail->SMTPDebug = 0; 
			$mail->Host = EmailHost;
			$mail->Port = EmailPort;
			$mail->SMTPSecure = 'tls';
			$mail->SMTPAuth = true;
			$mail->Username = EmailUsername;
			$mail->Password = EmailPassword;
		}
		else {
			$mail->isSendmail();
		}
		$mail->setFrom(EmailAddress, 'Correzioni OliMat'); 
		$mail->addAddress($ContestantEmail);
		$mail->Subject = 'Codice di verifica - Correzioni Olimpiadi';
		$mail->isHTML(true);
		$mail->Body = $MailText;
		if (!$mail->send()) {
			return ['type'=>'bad', 'text'=>'Il codice non è stato inviato a causa di un errore nell\'invio della mail'];
		}
		
		Query($db, QueryDelete('VerificationCodes', ['email'=>$ContestantEmail]));
		
		$TimestampSql = (new Datetime('now'))->format('Y-m-d H:i:s');
		Query($db, QueryInsert('VerificationCodes', ['email'=>$ContestantEmail, 'code'=>$code, 'timestamp'=>$TimestampSql]));
		
		return ['type'=>'good', 'text'=>'Codice inviato con successo', 'data'=>['email'=>$ContestantEmail]];
	}

	function CheckCode($db, $ContestantEmail, $code) {
		$row = OneResultQuery($db, QuerySelect('VerificationCodes', ['email'=>$ContestantEmail, 'code'=>$code]));
		if (is_null($row)) return ['type'=>'bad', 'text'=>'Il codice di verifica non è corretto'];
		$timestamp = new Datetime($row['timestamp']);
		$DiffHours = $timestamp->diff(new Datetime('now'))->format('%h');
		if ($DiffHours >= 6) return ['type'=>'bad', 'text'=>'Il codice di verifica è scaduto'];
		
		return ['type'=>'good', 'text'=>'Il codice di verifica è corretto'];
	}
	
	$db= OpenDbConnection();
	$data = json_decode($_POST['data'], 1);
	
	if ($data['type'] == 'send') SendObject(SendCode($db, $data['email']));
	else if ($data['type'] == 'check') SendObject(CheckCode($db, $data['email'], $data['code']));
	else SendObject(['type'=>'bad', 'text'=>'L\'azione scelta non esiste']);
	
	$db->close();
