<?php
$dbServer='localhost';
$dbUser='Olimpiadi';
$dbPass='alfabeto';
$dbName='CorOli';

function escape_input($value)
{
	if (get_magic_quotes_gpc()) $value = stripslashes($value);
	if (!is_numeric($value)) $value = "'" . mysql_real_escape_string($value) . "'";
	return $value;
}

//~ Queste righe di seguito sono il comando da dare per creare un utente che abbia le credenziali e i privilegi giusti.
//~ GRANT USAGE ON *.* TO 'Olimpiadi'@'localhost' IDENTIFIED BY PASSWORD '*55EEA580EAC9D7F09E0DF993C96F31F2BD5385A9';
//~ GRANT ALL PRIVILEGES ON `CorOli`.* TO 'Olimpiadi'@'localhost' WITH GRANT OPTION;

?>