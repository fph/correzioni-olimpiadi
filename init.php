<?php
include 'dbCredentials.php';
mysql_connect('localhost',$dbUser,$dbPass) or die(mysql_error());

$query='DROP DATABASE IF EXISTS `'.$dbName.'`;';
mysql_query ( $query ) or die(mysql_error());

$query='CREATE DATABASE IF NOT EXISTS `'.$dbName.'`;';
mysql_query ( $query ) or die(mysql_error());

echo "Database ".$dbName." created.\n";

mysql_select_db($dbName) or die(mysql_error());


$query=
'CREATE TABLE IF NOT EXISTS `Users` (
	`id` int NOT NULL AUTO_INCREMENT,
	`user` varchar(31) NOT NULL,
	`pass` varchar(63) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY(`user`)
) ENGINE=InnoDB;';
mysql_query( $query ) or die(mysql_error());

echo "Table Users created.\n";

$query=
'CREATE TABLE IF NOT EXISTS `Contests` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(31) NOT NULL,
	`date` date,
	PRIMARY KEY (`id`),
	UNIQUE KEY(`name`)
) ENGINE=InnoDB;';
mysql_query( $query ) or die(mysql_error());

echo "Table Contests created.\n";

$query=
'CREATE TABLE IF NOT EXISTS `Contestants` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(31) NOT NULL,
	`surname` varchar(31) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY(`surname`)
) ENGINE=InnoDB;';
mysql_query( $query ) or die(mysql_error());

echo "Table Contestants created.\n";

$query=
'CREATE TABLE IF NOT EXISTS `Participations` (
	`id` int NOT NULL AUTO_INCREMENT,
	`ContestId` int NOT NULL,
	`ContestantId` int NOT NULL,

	PRIMARY KEY (`id`),
	KEY(`ContestId`),
	KEY(`ContestantId`),

	FOREIGN KEY (ContestId) REFERENCES Contests(id)
		ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (ContestantId) REFERENCES Contestants(id)
		ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;';
mysql_query( $query ) or die(mysql_error());

echo "Table Participations created.\n";

$query=
'CREATE TABLE IF NOT EXISTS `Problems` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(31) NOT NULL,
	`ContestId` int NOT NULL,
	
	PRIMARY KEY (`id`),
	KEY(`ContestId`),

	FOREIGN KEY (ContestId) REFERENCES Contests(id)
		ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;';
mysql_query( $query ) or die(mysql_error());

echo "Table Problems created.\n";

$query=
'CREATE TABLE IF NOT EXISTS `Corrections` (
	`id` int NOT NULL AUTO_INCREMENT,
	`ProblemId` int NOT NULL,
	`ContestantId` int NOT NULL,
	`mark` int,
	`comment` varchar(255),
	
	PRIMARY KEY (`id`),
	KEY (`ProblemId`),
	KEY (`ContestantId`),

	FOREIGN KEY (ProblemId) REFERENCES Problems(id)
		ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (ContestantId) REFERENCES Contestants(id)
		ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;';
mysql_query( $query ) or die(mysql_error());

echo "Table Corrections created.\n";

mysql_close();
?>