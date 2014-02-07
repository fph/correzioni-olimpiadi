<?php
include 'dbCredentials.php';

function CreateDatabase() {
	global $dbServer, $dbUser, $dbPass, $dbName;
	$db=new mysqli ($dbServer, $dbUser, $dbPass);
	if($db->connect_errno) die ($db->connect_error);
	

	$query='DROP DATABASE IF EXISTS `'.$dbName.'`;'; //DEBUG
	$db->query($query) or die($db->error);

	$query='CREATE DATABASE IF NOT EXISTS `'.$dbName.'`;';
	$db->query($query) or die($db->error);

	echo "Database ".$dbName." created.\n";
	$db->select_db($dbName) or die($db->error);
	
	$query=
	'CREATE TABLE IF NOT EXISTS `Users` (
		`id` int NOT NULL AUTO_INCREMENT,
		`user` varchar(31) NOT NULL,
		`pass` varchar(63) NOT NULL,
		PRIMARY KEY (`id`),
		UNIQUE KEY(`user`)
	) ENGINE=InnoDB;';
	$db->query($query) or die($db->error);

	echo "Table Users created.\n";

	$query=
	'CREATE TABLE IF NOT EXISTS `Contests` (
		`id` int NOT NULL AUTO_INCREMENT,
		`name` varchar(31) NOT NULL,
		`date` date,
		PRIMARY KEY (`id`),
		UNIQUE KEY(`name`)
	) ENGINE=InnoDB;';
	$db->query($query) or die($db->error);

	echo "Table Contests created.\n";

	$query=
	'CREATE TABLE IF NOT EXISTS `Contestants` (
		`id` int NOT NULL AUTO_INCREMENT,
		`name` varchar(31) NOT NULL,
		`surname` varchar(31) NOT NULL,
		PRIMARY KEY (`id`),
		UNIQUE KEY(`surname`)
	) ENGINE=InnoDB;';
	$db->query($query) or die($db->error);

	echo "Table Contestants created.\n";

	$query=
	'CREATE TABLE IF NOT EXISTS `Participations` (
		`id` int NOT NULL AUTO_INCREMENT,
		`ContestId` int NOT NULL,
		`ContestantId` int NOT NULL,

		PRIMARY KEY (`id`),
		KEY(`ContestId`),
		KEY(`ContestantId`),

		FOREIGN KEY (`ContestId`) REFERENCES Contests(`id`)
			ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY (`ContestantId`) REFERENCES Contestants(`id`)
			ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB;';
	$db->query($query) or die($db->error);

	echo "Table Participations created.\n";

	$query=
	'CREATE TABLE IF NOT EXISTS `Problems` (
		`id` int NOT NULL AUTO_INCREMENT,
		`name` varchar(31) NOT NULL,
		`ContestId` int NOT NULL,
		
		PRIMARY KEY (`id`),
		KEY(`ContestId`),

		FOREIGN KEY (`ContestId`) REFERENCES Contests(`id`)
			ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB;';
	$db->query($query) or die($db->error);

	echo "Table Problems created.\n";

	$query=
	'CREATE TABLE IF NOT EXISTS `Corrections` (
		`id` int NOT NULL AUTO_INCREMENT,
		`ProblemId` int NOT NULL,
		`ContestantId` int NOT NULL,
		`mark` int,
		`comment` varchar(255),
		`UserId` int,
		
		PRIMARY KEY (`id`),
		KEY (`ProblemId`),
		KEY (`ContestantId`),

		FOREIGN KEY (`ProblemId`) REFERENCES Problems(`id`)
			ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY (`ContestantId`) REFERENCES Contestants(`id`)
			ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY (`UserId`) REFERENCES Users(`id`)
			ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB;';
	$db->query($query) or die($db->error);

	echo "Table Corrections created.\n";

	echo "All tables have been created.\n\n";
	$db->close();
}

function PopulateContestants() {
	global $dbServer, $dbUser, $dbPass, $dbName;
	$db=new mysqli ($dbServer, $dbUser, $dbPass);
	if($db->connect_errno) die ($db->connect_error);
	
	$query="INSERT INTO $dbName.`Contestants` (`name`, `surname`) VALUES
		('Federico', 'Glaudo'),
		('Giada', 'Franz'),
		('Gioacchino', 'Antonelli'),
		('Luca', 'Minutillo Menga'),
		('Francesco', 'Florian'),
		('Claudio', 'Afeltra'),
		('Paolo', 'Abiuso'),
		('Leonardo', 'Fiore'),
		('Lorenzo', 'Benedini'),
		('Davide', 'Lofano'),
		('Alice', 'Cortinovis'),
		('Emanuele', 'Tron'),
		('Matteo', 'Becchi'),
		('Filippo', 'Revello'),
		('Fabio', 'Ferri'),
		('Luigi', 'Pagano');";
	$db->query($query) or die($db->error);
	$db->close();

	echo "Table Contestants Populated.\n";
}

function PopulateContests() {
	global $dbServer, $dbUser, $dbPass, $dbName;
	$db=new mysqli ($dbServer,$dbUser,$dbPass);
	if($db->connect_errno) die ($db->connect_error);
	
	$query="INSERT INTO $dbName.`Contests` (`name`) VALUES
		('Senior 2013'),
		('WinterCamp 2011 Ammissione'),
		('Preimo 2010 TST giorno 1'),
		('Preimo 2010 TST giorno 2'),
		('IMO 2013 day1'),
		('Senior 2012 Test Iniziale');";
	$db->query($query) or die($db->error);
	$db->close();

	echo "Table Contests Populated.\n";
}

CreateDatabase();
PopulateContestants();
PopulateContests();

?>