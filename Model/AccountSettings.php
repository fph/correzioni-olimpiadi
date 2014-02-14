<?php
require_once "../Utilities.php";
SuperRequire_once("General","TemplateCreation.php");
SuperRequire_once("General","SessionManager.php");
SuperRequire_once("General","sqlUtilities.php");

if( !is_null( $_POST["NewUsername"] ) ) {
	$db=OpenDbConnection();
	
	$SameUsername=OneResultQuery($db, QuerySelect('Users',['username'=>$_POST['NewUsername']]));
	
	if( !is_null( $SameUsername ) ) {
		$db->close();
		TemplatePage("AccountSettings",
		['Index'=>'index.php','Configurazione Account'=>'AccountSettings.php'],1,
		['type'=>'bad', 'text'=>'Username già in uso da un utente, scegline un altro']);
		die();
	}
	
	Query($db, QueryUpdate('Users',['id'=>GetUserIdBySession()],['username'=>$_POST['NewUsername']]));
	
	$db->close();
	StartSession(GetUserIdBySession(),$_POST['NewUsername']);
	
	TemplatePage("AccountSettings",
	['Index'=>'index.php','Configurazione Account'=>'AccountSettings.php'],1,
	['type'=>'good', 'text'=>'Username cambiato con successo']);
	
	die();
}

else if ( !is_null( $_POST['NewPassword'] ) and !is_null( $_POST['OldPassword'] ) ) {
	
	if( strlen( $_POST['NewPassword'] ) < 4 ) {
		TemplatePage("AccountSettings",
		['Index'=>'index.php','Configurazione Account'=>'AccountSettings.php'],1,
		['type'=>'bad', 'text' => 'La nuova password è troppo breve.']);
		
		die();
	}
	$db=OpenDbConnection();
	
	$CorrectOldPass=OneResultQuery($db,QuerySelect('Users',['id'=>GetUserIdBySession(),'passHash'=>passwordHash($_POST['OldPassword']) ] ) );
	
	if( is_null($CorrectOldPass) ) {
		$db->close();
		TemplatePage("AccountSettings",
		['Index'=>'index.php','Configurazione Account'=>'AccountSettings.php'],1,
		['type'=>'bad', 'text'=>'La vecchia password non è corretta']);
		
		die();
	}
	
	Query($db,QueryUpdate('Users',['id'=>GetUserIdBySession()],['passHash'=>passwordHash($_POST['NewPassword'])]));
	
	$db->close();
	TemplatePage("AccountSettings",
	['Index'=>'index.php','Configurazione Account'=>'AccountSettings.php'],1,
	['type'=>'good', 'text'=>'Password cambiata con successo']);
	die();
}

TemplatePage("AccountSettings",['Index'=>'index.php','Configurazione Account'=>'AccountSettings.php']);
die();
?>
