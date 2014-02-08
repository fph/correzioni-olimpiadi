<?php

include_once "dbCredentials.php";
include_once "SessionManager.php";

session_start();

if (!isset($_SESSION["UserId"]) or time()-$_SESSION["LoginTimestamp"]>3600) EndSession();
else header("Location: index.php");

if (!is_null($_POST["user"])) VerifyCredentials($_POST["user"],$_POST["psw"]);


	include "View/Login.php";
?>
