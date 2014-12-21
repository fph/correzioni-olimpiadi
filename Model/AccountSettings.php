<?php
require_once "../Utilities.php";
SuperRequire_once("General","TemplateCreation.php");
SuperRequire_once("General","SessionManager.php");
SuperRequire_once("General","sqlUtilities.php");

function ChangeUsername ( $db , $UserId , $username ) {
	$username=htmlentities($username,ENT_QUOTES);
	if( !is_string($username) or strlen( $username )>username_MAXLength or strlen( $username )<username_MINLength ) {
		return ['type'=>'bad', 'text'=>'Lo username deve essere una stringa con un numero di caratteri tra '.username_MINLength.' e '.username_MAXLength.' (i caratteri speciali valgono più degli altri)'];
	}
	
	$UsernameDuplicate=OneResultQuery($db,QuerySelect('Users',['username'=>$username]));
	if( !is_null( $UsernameDuplicate ) ) {
		return ['type'=>'bad', 'text'=>'È già presente un utente con lo stesso username'];
	}
	
	$SameUsername=OneResultQuery($db, QuerySelect('Users',['username'=>$username]));
	if( !is_null( $SameUsername ) ) {
		return ['type'=>'bad', 'text'=>'Username già in uso da un utente, scegline un altro'];
	}
	
	Query($db, QueryUpdate('Users',['id'=>$UserId],['username'=>$username]));
	
	StartSession($UserId,$username);
	
	return ['type'=>'good', 'text'=>'Username cambiato con successo'];
}

function ChangePassword( $db , $UserId , $OldPassword , $NewPassword ) {
	if( !is_string($NewPassword) or strlen( $NewPassword )>password_MAXLength or strlen( $NewPassword )<password_MINLength ) {
		return ['type'=>'bad', 'text'=>'La password deve essere una stringa con un numero di caratteri tra '.password_MINLength.' e '.password_MAXLength];
	}
	
	$CorrectOldPass=OneResultQuery($db,QuerySelect('Users',['id'=>$UserId,'passHash'=>PasswordHash($OldPassword) ] ) );
	if( is_null($CorrectOldPass) ) {
		return ['type'=>'bad', 'text'=>'La vecchia password non è corretta'];
	}
	
	Query($db,QueryUpdate('Users',['id'=>$UserId],['passHash'=>PasswordHash($NewPassword)]));
	
	return ['type'=>'good', 'text'=>'Password cambiata con successo'];
}

$db=OpenDbConnection();

$Message;

if ( !isset($_POST['type']) ) $Message=null;
else if( $_POST['type'] == 'ChangeUsername' ) $Message=ChangeUsername( $db , GetUserIdBySession(), $_POST['NewUsername'] );
else if ( $_POST['type'] == 'ChangePassword' ) $Message=ChangePassword( $db , GetUserIdBySession() , $_POST['OldPassword'] , $_POST['NewPassword']);
else  $Message=null;

$db->close();
TemplatePage("AccountSettings",['Index'=>'index.php','Configurazione Account'=>'AccountSettings.php'],1, $Message);

?>
