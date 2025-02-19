<?php
require_once 'Utilities.php';
SuperRequire_once('General', 'sqlUtilities.php');
SuperRequire_once('General', 'PermissionManager.php');


function CreateDatabase() {
	$db = new mysqli (dbServer, dbUser, dbPass);
	if ($db->connect_errno) die ($db->connect_error);
	
	// $query='DROP DATABASE IF EXISTS `'.dbName.'`'; //DEBUG
	// Query($db, $query);

	$query = 'CREATE DATABASE IF NOT EXISTS `'.dbName.'`';
	Query($db, $query);

	echo 'Database '.dbName.' created.'.NewLine().NewLine();
	$db->close();
	
	$db = OpenDbConnection();
	
	$query=
	'CREATE TABLE IF NOT EXISTS `Users` (
		`id` int NOT NULL AUTO_INCREMENT,
		`username` varchar('.username_MAXLength.') NOT NULL,
		`passHash` varchar(255) NOT NULL,
		`role` int NOT NULL DEFAULT 0,
		PRIMARY KEY (`id`),
		UNIQUE KEY(`username`)
	) ENGINE=InnoDB';
	Query($db, $query);
	echo 'Table Users created.'.NewLine();
	
	$query=
	'CREATE TABLE IF NOT EXISTS `Contests` (
		`id` int NOT NULL AUTO_INCREMENT,
		`name` varchar('.ContestName_MAXLength.') NOT NULL,
		`date` date,
		`NotAcceptedEmail` varchar('.ContestNotAcceptedEmail_MAXLength.') NOT NULL,
		`ForwardRegistrationEmail` varchar ('.EmailAddress_MAXLength.') NOT NULL,
		`blocked` Boolean,
		`SolutionsZip` varchar(31) DEFAULT NULL,
		PRIMARY KEY (`id`),
		KEY(`name`)
	) ENGINE=InnoDB';
	Query($db, $query);
	echo 'Table Contests created.'.NewLine();

	$query=
	'CREATE TABLE IF NOT EXISTS `Permissions` (
		`id` int NOT NULL AUTO_INCREMENT,
		`UserId` int NOT NULL,
		`ContestId` int NOT NULL,
		
		PRIMARY KEY (`id`),
		KEY (`UserId`),
		KEY (`ContestId`),
		
		FOREIGN KEY (`UserId`) REFERENCES Users(`id`)
			ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY (`ContestId`) REFERENCES Contests(`id`)
			ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB';
	Query($db, $query);
	echo 'Table Permissions created.'.NewLine();
	
	$query=
	'CREATE TABLE IF NOT EXISTS `Contestants` (
		`id` int NOT NULL AUTO_INCREMENT,
		`name` varchar('.ContestantName_MAXLength.') NOT NULL,
		`surname` varchar('.ContestantSurname_MAXLength.') NOT NULL,
		`school` varchar('.ContestantSchool_MAXLength.') NOT NULL,
		`SchoolCity` varchar('.ContestantSchoolCity_MAXLength.') NOT NULL,
		`email` varchar('.EmailAddress_MAXLength.') NOT NULL,
		`LastOlympicYear` int NOT NULL DEFAULT 2050,
		PRIMARY KEY (`id`),
		KEY(`surname`)
	) ENGINE=InnoDB';
	Query($db, $query);
	echo 'Table Contestants created.'.NewLine();

	$query=
	'CREATE TABLE IF NOT EXISTS `Participations` (
		`id` int NOT NULL AUTO_INCREMENT,
		`ContestId` int NOT NULL,
		`ContestantId` int NOT NULL,
		`email` Boolean NOT NULL DEFAULT false,
		`solutions` varchar(31) DEFAULT NULL,
		`PastCamps` int DEFAULT NULL,

		PRIMARY KEY (`id`),
		KEY(`ContestId`),
		KEY(`ContestantId`),

		FOREIGN KEY (`ContestId`) REFERENCES Contests(`id`)
			ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY (`ContestantId`) REFERENCES Contestants(`id`)
			ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB';
	Query($db, $query);
	echo 'Table Participations created.'.NewLine();

	$query=
	'CREATE TABLE IF NOT EXISTS `Problems` (
		`id` int NOT NULL AUTO_INCREMENT,
		`ContestId` int NOT NULL,
		`name` varchar('.ProblemName_MAXLength.') NOT NULL,
		
		PRIMARY KEY (`id`),
		KEY(`ContestId`),

		FOREIGN KEY (`ContestId`) REFERENCES Contests(`id`)
			ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB';
	Query($db, $query);
	echo 'Table Problems created.'.NewLine();

	$query=
	'CREATE TABLE IF NOT EXISTS `Corrections` (
		`id` int NOT NULL AUTO_INCREMENT,
		`ProblemId` int NOT NULL,
		`ContestantId` int NOT NULL,
		`mark` decimal(3, 1),
		`comment` TEXT DEFAULT \'\',
		`UserId` int,
		
		PRIMARY KEY (`id`),
		KEY (`ProblemId`),
		KEY (`ContestantId`),

		FOREIGN KEY (`ProblemId`) REFERENCES Problems(`id`)
			ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY (`ContestantId`) REFERENCES Contestants(`id`)
			ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY (`UserId`) REFERENCES Users(`id`)
			ON DELETE SET NULL ON UPDATE CASCADE
	) ENGINE=InnoDB';
	Query($db, $query);
	echo 'Table Corrections created.'.NewLine();
	
	$query=
	'CREATE TABLE IF NOT EXISTS `VerificationCodes` (
		`email` varchar('.EmailAddress_MAXLength.') NOT NULL,
		`code` char(12) NOT NULL,
		`timestamp` timestamp NOT NULL,
		
		PRIMARY KEY (`email`)
	) ENGINE=InnoDB';
	Query($db, $query);
	echo 'Table VerificationCodes created.'.NewLine();

	echo 'All tables have been created'.NewLine().NewLine();
	$db->close();
}

function PopulateUsers($db) {
	$Users = [
		['username'=>'Xamog', 		'password'=>'meraviglioso', 'role'=>1], 
		['username'=>'LudoP', 		'password'=>'yochicco', 'role'=>0], 
		['username'=>'dario2994', 	'password'=>'acca', 'role'=>2], 
		['username'=>'fph', 		'password'=>'pizzica', 'role'=>0], 
		['username'=>'walypala23', 	'password'=>'gamma', 'role'=>0], 
		['username'=>'SimoTheWolf', 'password'=>'vero o falso?', 'role'=>0]
	];
	
	foreach ($Users as $User) {
		Query($db, QueryInsert('Users', ['username'=>$User['username'], 'passHash'=>PasswordHash($User['password']), 'role'=>$User['role']]));
	}

	echo 'Table Users Populated.'.NewLine();
}

function PopulateContests($db) {
	$Contests = [	
		['name'=>'Senior 2013', 				'date'=>'2006-04-29', 	'blocked'=>1, 'NotAcceptedEmail'=>'Sei scarso, guarda:', 'ForwardRegistrationEmail'=>''],
		['name'=>'WinterCamp 2011 Ammissione', 	'date'=>'2007-02-26', 	'blocked'=>1, 'NotAcceptedEmail'=>'', 'ForwardRegistrationEmail'=>'nonexistent298432@gmail.com'],
		['name'=>'Preimo 2010 TST giorno 1', 	'date'=>'2013-12-25', 	'blocked'=>1, 'NotAcceptedEmail'=>'', 'ForwardRegistrationEmail'=>''],
		['name'=>'Preimo 2010 TST giorno 2', 	'date'=>'2010-08-15', 	'blocked'=>0, 'NotAcceptedEmail'=>'', 'ForwardRegistrationEmail'=>''],
		['name'=>'IMO 2013 day1', 				'date'=>'2033-07-15',	'blocked'=>0, 'NotAcceptedEmail'=>'', 'ForwardRegistrationEmail'=>''],
		['name'=>'Senior 2012 Test Iniziale', 	'date'=>'2007-04-04',	'blocked'=>0, 'NotAcceptedEmail'=>'Va bene cosi, la prossima volta andrà meglio.', 'ForwardRegistrationEmail'=>'']
	];
	
	foreach ($Contests as $Contest) {
		Query($db, QueryInsert('Contests', ['name'=>$Contest['name'], 'date'=>$Contest['date'], 'blocked'=>$Contest['blocked'], 'NotAcceptedEmail'=>$Contest['NotAcceptedEmail'], 'ForwardRegistrationEmail'=>$Contest['ForwardRegistrationEmail'] ]));
	}

	echo 'Table Contests Populated.'.NewLine();
}

function PopulatePermissions($db) {
	$Users = ManyResultQuery($db, QuerySelect('Users', null, ['id', 'role']));
	$Contests = ManyResultQuery($db, QuerySelect('Contests', null, ['id']));
	
	foreach ($Contests as $Contest) {
		foreach ($Users as $User) {
			if (mt_rand(0, 1) == 1 and $User['role'] == 0) {
				Query($db, QueryInsert('Permissions', ['UserId'=>$User['id'], 'ContestId'=>$Contest['id']]));
			}
		}
	}

	echo 'Table Permissions Populated.'.NewLine();
}

function PopulateContestants($db) {
	$Contestants = [	
		[	'name'=>'Federico', 	
			'surname'=>'Glaudo',
			'school'=>'L.S. Righi',
			'SchoolCity'=>'Roma, RM',				
			'email'=>'dario2994@gmail.com', 
			'LastOlympicYear'=>2030
		],
		[
			'name'=>'Giada', 
			'surname'=>'Franz',	
			'school'=>'L.S. Marinelli',
			'SchoolCity'=>'Napoli, NA',	
			'email'=>'walypala23@gmail.com', 
			'LastOlympicYear'=>2016
		],
		[
			'name'=>'Luca',
			'surname'=>'Minutillo Menga',
			'school'=>'L.S. Staminchia',
			'SchoolCity'=>'Poretto, BR',
			'email'=>'porno@star.pr', 
			'LastOlympicYear'=>2018
		],
		[
			'name'=>'Francesco',
			'surname'=>'Florian',
			'school'=>'L.S. Copernico',
			'SchoolCity'=>'Mazzulonia, XX',
			'email'=>'fraflo@gmail.com', 
			'LastOlympicYear'=>2020
		],
		[
			'name'=>'Claudio', 
			'surname'=>'Afeltra',
			'school'=>'L.S. Sambuca',
			'SchoolCity'=>'Nordissimo, LF',
			'email'=>'tarvisio@forever.it', 
			'LastOlympicYear'=>2021
		],
		[
			'name'=>'Emanuele', 	
			'surname'=>'Tron',				
			'school'=>'L.S. Anzianotto',
			'SchoolCity'=>'Barcia, LA',		
			'email'=>'trontolino@amoroso.com', 
			'LastOlympicYear'=>2022
		],
		[
			'name'=>'Matteo', 		
			'surname'=>'Becchi',			
			'school'=>'L.C. Calasi',
			'SchoolCity'=>'Paesino, PR',			
			'email'=>'matteo.bec@chi.it', 
			'LastOlympicYear'=>2010
		],
		[
			'name'=>'Filippo', 	
			'surname'=>'Revello',			
			'school'=>'L.C. Anselmo',
			'SchoolCity'=>'Brutta, CI',			
			'email'=>'fifaloser@gmail.com', 
			'LastOlympicYear'=>2005
		],
		[
			'name'=>'Fabio', 		
			'surname'=>'Ferri',				
			'school'=>'L.C. Rambokid',
			'SchoolCity'=>'Chiusi, TO',			
			'email'=>'fabio.ferri@libero.com', 
			'LastOlympicYear'=>2004
		]
	];
	
	foreach ($Contestants as $Contestant) {
		Query($db, QueryInsert('Contestants', ['name'=>$Contestant['name'], 'surname'=>$Contestant['surname'], 'school'=>$Contestant['school'], 'SchoolCity'=>$Contestant['SchoolCity'], 'email'=>$Contestant['email'], 'LastOlympicYear'=>$Contestant['LastOlympicYear']]));
	}
	
	echo 'Table Contestants Populated.'.NewLine();
}

function PopulateParticipations($db) {
	$Contestants = ManyResultQuery($db, QuerySelect('Contestants', null, ['id']));
	$Contests = ManyResultQuery($db, QuerySelect('Contests', null, ['id']));
	
	foreach ($Contests as $Contest) {
		foreach ($Contestants as $Contestant) {
			if (mt_rand(0, 1) == 1) {
				Query($db, QueryInsert('Participations', [
					'ContestId'=>$Contest['id'], 
					'ContestantId'=>$Contestant['id'], 
					'email'=>mt_rand(0, 1),
					'PastCamps'=>mt_rand(0,5)
				]));
			}
		}
	}
	
	echo 'Table Participations Populated.'.NewLine();
}

function PopulateProblems($db) {
	$Problems = [	
		['name'=>'1', 'ContestId'=>1],
		['name'=>'2', 'ContestId'=>1],
		['name'=>'3', 'ContestId'=>1],
		['name'=>'4', 'ContestId'=>1],
		['name'=>'5', 'ContestId'=>1],
		['name'=>'6', 'ContestId'=>1],
		['name'=>'7', 'ContestId'=>1],
		['name'=>'8', 'ContestId'=>1],
		['name'=>'9', 'ContestId'=>1],
		['name'=>'10', 'ContestId'=>1],
		['name'=>'11', 'ContestId'=>1],
		['name'=>'12', 'ContestId'=>1],
		['name'=>'13', 'ContestId'=>1],
		['name'=>'14', 'ContestId'=>1],
		['name'=>'15', 'ContestId'=>1],
		['name'=>'16', 'ContestId'=>1],
		['name'=>'A1', 'ContestId'=>2],
		['name'=>'A2', 'ContestId'=>2],
		['name'=>'A3', 'ContestId'=>2],
		['name'=>'C1', 'ContestId'=>2],
		['name'=>'C2', 'ContestId'=>2],
		['name'=>'C3', 'ContestId'=>2],
		['name'=>'G1', 'ContestId'=>2],
		['name'=>'G2', 'ContestId'=>2],
		['name'=>'G3', 'ContestId'=>2],
		['name'=>'N1', 'ContestId'=>2],
		['name'=>'N2', 'ContestId'=>2],
		['name'=>'N3', 'ContestId'=>2],
		['name'=>'1', 'ContestId'=>3],
		['name'=>'2', 'ContestId'=>3],
		['name'=>'3', 'ContestId'=>3],
		['name'=>'1', 'ContestId'=>4],
		['name'=>'2', 'ContestId'=>4],
		['name'=>'3', 'ContestId'=>4],
		['name'=>'Problem 1', 'ContestId'=>5],
		['name'=>'Problem 2', 'ContestId'=>5],
		['name'=>'Problem 3', 'ContestId'=>5],
		['name'=>'Algebra pomeriggio', 'ContestId'=>6],
		['name'=>'Algebra mattina', 'ContestId'=>6],
		['name'=>'Geometria 2', 'ContestId'=>6],
		['name'=>'Geometria contosa', 'ContestId'=>6],
		['name'=>'Problema difficile', 'ContestId'=>6]
	];
	
	foreach ($Problems as $Problem) {
		Query($db, QueryInsert('Problems', ['name'=>$Problem['name'], 'ContestId'=>$Problem['ContestId']]));
	}

	echo 'Table Problems Populated.'.NewLine();
}

function PopulateCorrections($db) {
	$Users = ManyResultQuery($db, QuerySelect('Users', null, ['id']));
	$Contests = ManyResultQuery($db, QuerySelect('Contests', null, ['id']));
	
	$CharactersList = 'abcdefghilmnopqrstuvzabcdefghilmnopqrstuvz        1234567890';
	$CharactersNumber = strlen($CharactersList);
	
	foreach ($Contests as $Contest) {
		$Problems = ManyResultQuery($db, QuerySelect('Problems', ['ContestId'=>$Contest['id']], ['id']));
		$Contestants = ManyResultQuery($db, QuerySelect('Participations', ['ContestId'=>$Contest['id']], ['ContestantId']));
		$Correctors = [];
		foreach ($Users as $user) {
			if (VerifyPermission($db, $user['id'], $Contest['id']) == 1) {
				$Correctors[]=$user;
			}
		}
		$CorrectorsNumber = count($Correctors);
		foreach ($Problems as $Problem) {
			foreach ($Contestants as $Contestant) {
				if (mt_rand(0, 1) == 1) {
					$CommentLength = mt_rand(0, 200);
					$Comment = '';
					for ($j=0; $j<$CommentLength; $j++) $Comment .= $CharactersList[mt_rand(0, $CharactersNumber-1)];
					$CorrectorId = $Correctors[mt_rand(0, $CorrectorsNumber-1)]['id'];
					Query($db, QueryInsert('Corrections', 
					['ProblemId'=>$Problem['id'], 'ContestantId'=>$Contestant['ContestantId'], 'mark'=>mt_rand(0, 14)/2, 'comment'=>$Comment, 'UserId'=>$CorrectorId]
					));
				}
			}
		}
	}

	echo 'Table Corrections Populated.'.NewLine();
}

CreateDatabase();

$db = OpenDbConnection();

PopulateUsers($db);
PopulateContests($db);
PopulatePermissions($db);
PopulateContestants($db);
PopulateParticipations($db);
PopulateProblems($db);
PopulateCorrections($db); //It's slow... it's not a problem.
// TODO: PopulateVerificationCodes
echo 'All tables have been populated.'.NewLine().NewLine();

$db->close();

echo 'The database has been completely initialized!'.NewLine();
