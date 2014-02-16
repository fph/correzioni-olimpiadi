<?php
require_once "Utilities.php";
SuperRequire_once("General","sqlUtilities.php");
SuperRequire_once("General","PermissionManager.php");

function CreateDatabase() {
	$db=new mysqli (dbServer, dbUser, dbPass);
	if($db->connect_errno) die ($db->connect_error);
	
	$query='DROP DATABASE IF EXISTS `'.dbName.'`;'; //DEBUG
	Query($db, $query);

	$query='CREATE DATABASE IF NOT EXISTS `'.dbName.'`;';
	Query($db, $query);

	echo "Database ".dbName." created.\n";
	$db->close();
	
	$db=OpenDbConnection();
	
	$query=
	'CREATE TABLE IF NOT EXISTS `Users` (
		`id` int NOT NULL AUTO_INCREMENT,
		`username` varchar(31) NOT NULL,
		`passHash` varchar(255) NOT NULL,
		PRIMARY KEY (`id`),
		UNIQUE KEY(`username`)
	) ENGINE=InnoDB;';
	Query($db, $query);
	echo "Table Users created.\n";
	
	$query=
	'CREATE TABLE IF NOT EXISTS `Administrators` (
		`UserId` int NOT NULL,
		PRIMARY KEY (`UserId`),
		
		FOREIGN KEY (`UserId`) REFERENCES Users(`id`)
			ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB;';
	Query($db, $query);
	echo "Table Administrators created.\n";
	
	$query=
	'CREATE TABLE IF NOT EXISTS `Contests` (
		`id` int NOT NULL AUTO_INCREMENT,
		`name` varchar(31) NOT NULL,
		`date` date,
		PRIMARY KEY (`id`),
		UNIQUE KEY(`name`)
	) ENGINE=InnoDB;';
	Query($db, $query);
	echo "Table Contests created.\n";

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
	) ENGINE=InnoDB;';
	Query($db, $query);
	echo "Table Permissions created.\n";
	
	$query=
	'CREATE TABLE IF NOT EXISTS `Contestants` (
		`id` int NOT NULL AUTO_INCREMENT,
		`name` varchar(31) NOT NULL,
		`surname` varchar(31) NOT NULL,
		PRIMARY KEY (`id`),
		UNIQUE KEY(`surname`)
	) ENGINE=InnoDB;';
	Query($db, $query);
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
	Query($db, $query);
	echo "Table Participations created.\n";

	$query=
	'CREATE TABLE IF NOT EXISTS `Problems` (
		`id` int NOT NULL AUTO_INCREMENT,
		`ContestId` int NOT NULL,
		`name` varchar(31) NOT NULL,
		
		PRIMARY KEY (`id`),
		KEY(`ContestId`),

		FOREIGN KEY (`ContestId`) REFERENCES Contests(`id`)
			ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB;';
	Query($db, $query);
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
			ON DELETE SET NULL ON UPDATE CASCADE
	) ENGINE=InnoDB;';
	Query($db, $query);
	echo "Table Corrections created.\n";

	echo "All tables have been created.\n\n";
	$db->close();
}

function PopulateUsers($db) {
	$Users=['Xamog'=>'meraviglioso', 
			'LudoP'=>'yochicco', 
			'dario2994'=>'acca', 
			'fph'=>'pizzica', 
			'walypala23'=>'gamma', 
			'SimoTheWolf'=>'vero o falso?'];
	foreach($Users as $username => $password){
		Query($db,QueryInsert('Users',['username'=>$username, 'passHash'=>passwordHash($password)]));
	}

	echo "Table Users Populated.\n";
}

function PopulateAdministrators($db) {
	$dario2994_id=OneResultQuery($db,QuerySelect('Users',['username'=>'dario2994'],['id']))['id'];
	Query($db,QueryInsert('Administrators',['UserId'=>$dario2994_id]));

	echo "Table Users Populated.\n";
}

function PopulateContests($db) {
	$Contests=[	'Senior 2013'=>'1994-04-29',
				'WinterCamp 2011 Ammissione'=>'1994-04-29',
				'Preimo 2010 TST giorno 1'=>'2013-12-25',
				'Preimo 2010 TST giorno 2'=>'2010-08-15',
				'IMO 2013 day1'=> null,
				'Senior 2012 Test Iniziale'=> null];
	foreach($Contests as $name=>$date) {
		Query($db,QueryInsert('Contests',['name'=>$name,'date'=>$date]));
	}

	echo "Table Contests Populated.\n";
}

function PopulatePermissions($db){
	$Users=ManyResultQuery($db, QuerySelect('Users',null,['id']));
	$Contests=ManyResultQuery($db, QuerySelect('Contests',null,['id']));
	
	foreach($Contests as $Contest){
		foreach($Users as $User) {
			if( mt_rand(0,1)==1 and IsAdmin($db,$User['id'])==0 ){
				Query($db,QueryInsert('Permissions',['UserId'=>$User['id'],'ContestId'=>$Contest['id']]));
			}
		}
	}

	echo "Table Permissions Populated.\n";
}

function PopulateContestants($db) {
	$Contestants=[	'Federico'=>'Glaudo',
					'Giada'=>'Franz',
					'Gioacchino'=>'Antonelli',
					'Luca'=>'Minutillo Menga',
					'Francesco'=>'Florian',
					'Claudio'=>'Afeltra',
					'Paolo'=>'Abiuso',
					'Leonardo'=>'Fiore',
					'Lorenzo'=>'Benedini',
					'Davide'=>'Lofano',
					'Alice'=>'Cortinovis',
					'Emanuele'=>'Tron',
					'Matteo'=>'Becchi',
					'Filippo'=>'Revello',
					'Fabio'=>'Ferri',
					'Luigi'=>'Pagano'];
	foreach($Contestants as $name=>$surname) {
		Query($db,QueryInsert('Contestants',['name'=>$name,'surname'=>$surname]));
	}
	
	echo "Table Contestants Populated.\n";
}

function PopulateParticipations($db){
	$Contestants=ManyResultQuery($db,QuerySelect('Contestants',null,['id']));
	$Contests=ManyResultQuery($db,QuerySelect('Contests',null,['id']));
	
	foreach($Contests as $Contest) {
		foreach($Contestants as $Contestant){
			if( mt_rand(0,1)==1 ) {
				Query($db, QueryInsert('Participations',['ContestId'=>$Contest['id'],'ContestantId'=>$Contestant['id']]));
			}
		}
	}
	
	echo "Table Participations Populated.\n";
}

function PopulateProblems($db) {
	$Problems=[	['name'=>'1','ContestId'=>1],
				['name'=>'2','ContestId'=>1],
				['name'=>'3','ContestId'=>1],
				['name'=>'4','ContestId'=>1],
				['name'=>'5','ContestId'=>1],
				['name'=>'6','ContestId'=>1],
				['name'=>'7','ContestId'=>1],
				['name'=>'8','ContestId'=>1],
				['name'=>'9','ContestId'=>1],
				['name'=>'10','ContestId'=>1],
				['name'=>'11','ContestId'=>1],
				['name'=>'12','ContestId'=>1],
				['name'=>'13','ContestId'=>1],
				['name'=>'14','ContestId'=>1],
				['name'=>'15','ContestId'=>1],
				['name'=>'16','ContestId'=>1],
				['name'=>'A1','ContestId'=>2],
				['name'=>'A2','ContestId'=>2],
				['name'=>'A3','ContestId'=>2],
				['name'=>'C1','ContestId'=>2],
				['name'=>'C2','ContestId'=>2],
				['name'=>'C3','ContestId'=>2],
				['name'=>'G1','ContestId'=>2],
				['name'=>'G2','ContestId'=>2],
				['name'=>'G3','ContestId'=>2],
				['name'=>'N1','ContestId'=>2],
				['name'=>'N2','ContestId'=>2],
				['name'=>'N3','ContestId'=>2],
				['name'=>'1','ContestId'=>3],
				['name'=>'2','ContestId'=>3],
				['name'=>'3','ContestId'=>3],
				['name'=>'1','ContestId'=>4],
				['name'=>'2','ContestId'=>4],
				['name'=>'3','ContestId'=>4],
				['name'=>'Problem 1','ContestId'=>5],
				['name'=>'Problem 2','ContestId'=>5],
				['name'=>'Problem 3','ContestId'=>5]];
	
	foreach($Problems as $Problem) {
		Query($db,QueryInsert('Problems',['name'=>$Problem['name'], 'ContestId'=>$Problem['ContestId']]));
	}

	echo "Table Problems Populated.\n";
}

function PopulateCorrections($db){
	$Users=ManyResultQuery($db, QuerySelect('Users',null,['id']));
	$UsersNumber=count($Users);
	$Contests=ManyResultQuery($db, QuerySelect('Contests',null,['id']));
	
	$CharactersList='abcdefghilmnopqrstuvzabcdefghilmnopqrstuvz        1234567890';
	$CharactersNumber=strlen($CharactersList);
	
	foreach($Contests as $Contest) {
		$Problems=ManyResultQuery($db,QuerySelect('Problems',['ContestId'=>$Contest['id']],['id']));
		$Contestants=ManyResultQuery($db,QuerySelect('Participations',['ContestId'=>$Contest['id']],['ContestantId']));
		foreach($Problems as $Problem) {
			foreach($Contestants as $Contestant) {
				if( mt_rand(0,1)==1 ) {
					$CommentLength=mt_rand(0,200);
					$Comment='';
					for($j=0;$j<$CommentLength;$j++) $Comment .= $CharactersList[mt_rand(0,$CharactersNumber)];
					$UserId=$Users[mt_rand(0,$UsersNumber-1)]['id'];
					Query($db,QueryInsert('Corrections', 
					['ProblemId'=>$Problem['id'], 'ContestantId'=>$Contestant['ContestantId'], 'mark'=>mt_rand(0,7), 'comment'=>$Comment, 'UserId'=>$UserId]
					));
				}
			}
		}
	}

	echo "Table Corrections Populated.\n";
}

CreateDatabase();

$db=OpenDbConnection();

PopulateUsers($db);
PopulateAdministrators($db);
PopulateContests($db);
PopulatePermissions($db);
PopulateContestants($db);
PopulateParticipations($db);
PopulateProblems($db);
PopulateCorrections($db);

$db->close();

echo "THE DATABASE IS COMPLETELY INITIALIZED!\n";

?>
