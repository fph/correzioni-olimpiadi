<?php
require_once "../Utilities.php";

SuperRequire_once("General", "SessionManager.php");
SuperRequire_once("General", "AskInformation.php");
SuperRequire_once("General", "TemplateCreation.php");

$db=OpenDbConnection();
echo OneResultQuery($db, QuerySelect('Contestants',['id'=>2],['name','surname']) )['name'];
$db->close();

//~ $SessionStatus=CheckSession();
//~ 
//~ if( CheckSession() == -1 ) {
	//~ EndSession();
	//~ $v_ErrorMessage="Your session is expired, login again.";
	//~ TemplatePage("Login","Error",0);
	//~ die();
//~ }
//~ else if( CheckSession() == 1 ) {
	//~ SuperRedirect("Model","index.php");
	//~ die();
//~ }
//~ else if ( CheckSession()==0 and !is_null($_POST["user"]) ) {
	//~ $UserId=VerifyCredentials($_POST["user"],$_POST["psw"]);
	//~ 
	//~ if( $UserId == -1 ) {
		//~ $v_ErrorMessage="Incorrect username or password";
		//~ TemplatePage("Login","Error",0);
	//~ }
	//~ else {
		//~ StartSession($UserId,$_POST['user']);
		//~ SuperRedirect("Model","index.php");
		//~ die();
	//~ }
//~ }
//~ else if( CheckSession()==0 ) TemplatePage("Login","",0);
?>
