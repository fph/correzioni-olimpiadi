<?php
	require_once '../Utilities.php';
	SuperRequire_once('General', 'SessionManager.php');
	EndSession();
	SuperRedirect('Model', 'Login.php');
?>
