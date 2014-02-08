<?php
function escape_input($value)
{
	if (is_null($value)) $value="";
	if (get_magic_quotes_gpc()) $value = stripslashes($value);
	if (!is_numeric($value)) {
		$mysqli=new mysqli(dbServer, dbUser, dbPass);
		$value = "'" . $mysqli->real_escape_string($value) . "'";
	}
	return $value;
}

function passwordHash($pass) {
	$salt="trecentoquarantaseidue";
	return crypt($pass,$salt);
}
?>
