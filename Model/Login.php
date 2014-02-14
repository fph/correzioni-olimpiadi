<?php
require_once "../Utilities.php";

SuperRequire_once("General", "SessionManager.php");
SuperRequire_once("General", "sqlUtilities.php");
SuperRequire_once("General", "TemplateCreation.php");

$SessionStatus=CheckSession();

if( CheckSession() == -1 ) {
	EndSession();
	TemplatePage("Login",[],0,['type'=>'bad', 'text'=>"La sessione è scaduta, fai login di nuovo"]);
	die();
}
else if( CheckSession() == 1 ) {
	SuperRedirect("Model","index.php");
	die();
}
else if ( CheckSession()==0 and !is_null($_POST["username"]) ) {
	$db=OpenDbConnection();
	$UserId=OneResultQuery($db, QuerySelect('Users',
	['username'=>$_POST['username'],'passHash'=>passwordHash( $_POST['password'] )],
	['id']
	) ) ['id'];
	
	$db->close();
	
	if( is_null($UserId) ) {
		TemplatePage("Login",[],0,['type'=>'bad', 'text'=>"Username o password non corretti"]);
		die();
	}
	else {
		StartSession($UserId,$_POST['username']);
		SuperRedirect("Model","index.php");
		die();
	}
}
else if( CheckSession()==0 ) TemplatePage("Login",[],0);
?>
