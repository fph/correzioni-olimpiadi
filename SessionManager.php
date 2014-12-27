<?php
require_once "Utilities.php";


function LoadSession() { //If you just call session_start instead of this function, a notice might be raised.
	if( session_status()==PHP_SESSION_NONE ) session_start();
}

function StartSession($UserId, $username){
	LoadSession();
	$_SESSION["UserId"]=$UserId;
	$_SESSION['username']=$username;
	$_SESSION["LoginTimestamp"]=time();
}

function EndSession(){
	LoadSession();
	session_unset();
	session_destroy();
}

function CheckSession() {
	LoadSession();
	if ( !isset($_SESSION["UserId"]) ) return 0;
	if ( time()-$_SESSION["LoginTimestamp"]>3600 ) return -1;
	return 1;
}

function GetUserIdBySession() {
	LoadSession();
	if( isset($_SESSION['UserId']) ) return $_SESSION['UserId'];
	else return -1;
}

function GetUsernameBySession() {
	LoadSession();
	if( isset($_SESSION['username']) ) return $_SESSION['username'];
	else return '';
}

