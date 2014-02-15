<?php
require_once "Utilities.php";
SuperRequire_once("General","sqlUtilities.php");

function CreateDatabase() {
	$db=new mysqli (dbServer, dbUser, dbPass);
	if($db->connect_errno) die ($db->connect_error);
	

	$query='DROP DATABASE IF EXISTS `'.dbName.'`;'; //DEBUG
	$db->query($query) or die($db->error);

	$query='CREATE DATABASE IF NOT EXISTS `'.dbName.'`;';
	$db->query($query) or die($db->error);

	echo "Database ".dbName." created.\n";
	$db->select_db(dbName) or die($db->error);
	
	$query=
	'CREATE TABLE IF NOT EXISTS `Users` (
		`id` int NOT NULL AUTO_INCREMENT,
		`username` varchar(31) NOT NULL,
		`passHash` varchar(255) NOT NULL,
		PRIMARY KEY (`id`),
		UNIQUE KEY(`username`)
	) ENGINE=InnoDB;';
	$db->query($query) or die($db->error);
	
	echo "Table Users created.\n";
	
	$query=
	'CREATE TABLE IF NOT EXISTS `Administrators` (
		`UserId` int NOT NULL,
		PRIMARY KEY (`UserId`),
		
		FOREIGN KEY (`UserId`) REFERENCES Users(`id`)
			ON DELETE CASCADE ON UPDATE CASCADE
	) ENGINE=InnoDB;';
	$db->query($query) or die($db->error);
	
	echo "Table Administrators created.\n";
	
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
	$db->query($query) or die($db->error);
	
	echo "Table Permissions created.\n";
	
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
		`ContestId` int NOT NULL,
		`name` varchar(31) NOT NULL,
		
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
			ON DELETE SET NULL ON UPDATE CASCADE
	) ENGINE=InnoDB;';
	$db->query($query) or die($db->error);

	echo "Table Corrections created.\n";

	echo "All tables have been created.\n\n";
	$db->close();
}

function PopulateUsers() {
	$db=new mysqli (dbServer, dbUser, dbPass);
	if($db->connect_errno) die ($db->connect_error);
	
	//~ echo "CIAO";
	
	$query="INSERT INTO ".dbName.".`Users` (`username`,`passHash`) VALUES
		('Xamog','".passwordHash('meraviglioso')."'),
		('LudoP','".passwordHash('yochicco')."'),
		('dario2994','".passwordHash('acca')."'),
		('fph','".passwordHash('pizzica')."'),
		('walypala23','".passwordHash('gamma')."'),
		('SimoTheWolf','".passwordHash('vero o falso?')."');";
	//~ echo $query;
	$db->query($query) or die($db->error);
	$db->close();

	echo "Table Users Populated.\n";
}

function PopulateAdministrators() {
	$db=new mysqli (dbServer, dbUser, dbPass);
	if($db->connect_errno) die ($db->connect_error);
	
	$query="SELECT id FROM ".dbName.".Users WHERE username='dario2994';";
	//~ echo $query;
	$dario2994_id=$db->query($query) or die($db->error);
	$query="INSERT INTO ".dbName.".Administrators (UserId) VALUES (".mysqli_fetch_array($dario2994_id)['id'].");";
	$db->query($query) or die($db->error);
	$db->close();

	echo "Table Users Populated.\n";
}

function PopulateContests() {
	$db=new mysqli (dbServer, dbUser, dbPass);
	if($db->connect_errno) die ($db->connect_error);
	
	$query="INSERT INTO ".dbName.".`Contests` (`name`,`date`) VALUES
		('Senior 2013','1994-04-29'),
		('WinterCamp 2011 Ammissione','1994-04-29'),
		('Preimo 2010 TST giorno 1','2013-12-25'),
		('Preimo 2010 TST giorno 2','2010-08-15'),
		('IMO 2013 day1',null),
		('Senior 2012 Test Iniziale',null);";
	$db->query($query) or die($db->error);
	$db->close();

	echo "Table Contests Populated.\n";
}

function PopulatePermissions(){
	$db=new mysqli (dbServer, dbUser, dbPass);
	if($db->connect_errno) die ($db->connect_error);
	
	$query="SELECT id FROM ".dbName.".Users";
	$UsersResult=$db->query($query) or die($db->error);
	$n=0;
	$Users=[];
	while($Users[$n]=mysqli_fetch_array($UsersResult)['id'])$n++;
	
	$query="SELECT id FROM ".dbName.".Contests";
	$Contests=$db->query($query) or die($db->error);
	
	while($Contest=mysqli_fetch_array($Contests)['id']) {
		$m=mt_rand(0,$n);
		for($i=0;$i<$m;$i++) {
			$query="INSERT INTO ".dbName.".Permissions (UserId,ContestId) VALUES (".$Users[$i].",".$Contest.");";
			$db->query($query) or die($db->error);
		}
	}
	$db->close();

	echo "Table Permissions Populated.\n";
}

function PopulateContestants() {
	$db=new mysqli (dbServer, dbUser, dbPass);
	if($db->connect_errno) die ($db->connect_error);
	
	$query="INSERT INTO ".dbName.".`Contestants` (`name`, `surname`) VALUES
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

function PopulateParticipations(){
	$db=new mysqli (dbServer, dbUser, dbPass);
	if($db->connect_errno) die ($db->connect_error);

	$db->select_db(dbName) or die($db->error);

	$query="SELECT `id` FROM Contestants";
	$result=$db->query($query) or die($db->error);
	$n=0;
	$Contestants=[];
	while( $Contestants[$n] = mysqli_fetch_array($result)['id'] ) $n++;
	
	$query="SELECT `id` FROM Contests;";
	$result=$db->query($query) or die($db->error);
	while ( $row = mysqli_fetch_array($result) ) {
		$ContestId=$row['id'];
		$q=mt_rand(0,$n);
		//~ echo "$ContestId $q\n";
		for($i=0;$i<$q;$i++) {
			if(mt_rand(1,10)>=7) continue;
			
			$query="INSERT INTO `Participations` (ContestId,ContestantId) VALUES ($ContestId,$Contestants[$i]);";
			$db->query($query) or die($db->error);
		}
	}

	echo "Table Participations Populated.\n";
}

function PopulateProblems() {
	$db=new mysqli (dbServer, dbUser, dbPass);
	if($db->connect_errno) die ($db->connect_error);
	
	$query="INSERT INTO ".dbName.".`Problems` (`name`,`ContestId`) VALUES
		('1',1),
		('2',1),
		('3',1),
		('4',1),
		('5',1),
		('6',1),
		('7',1),
		('8',1),
		('9',1),
		('10',1),
		('11',1),
		('12',1),
		('13',1),
		('14',1),
		('15',1),
		('16',1),
		('A1',2),
		('A2',2),
		('A3',2),
		('C1',2),
		('C2',2),
		('C3',2),
		('G1',2),
		('G2',2),
		('G3',2),
		('N1',2),
		('N2',2),
		('N3',2),
		('1',3),
		('2',3),
		('3',3),
		('1',4),
		('2',4),
		('3',4),
		('Problem 1',5),
		('Problem 2',5),
		('Problem 3',5);";
	$db->query($query) or die($db->error);
	$db->close();

	echo "Table Problems Populated.\n";
}

function PopulateCorrections(){
	$db=new mysqli (dbServer, dbUser, dbPass);
	if($db->connect_errno) die ($db->connect_error);
	
	$db->select_db(dbName) or die($db->error);

	$query="SELECT `id` FROM Users;";
	$result=$db->query($query) or die($db->error);
	$qU=0;
	$Users=[];
	while($Users[$qU]=mysqli_fetch_array($result)['id'])$qU++;
	
	$CharactersList='abcdefghilmnopqrstuvzabcdefghilmnopqrstuvz        1234567890';
	$CharactersNumber=strlen($CharactersList);
	
	$query="SELECT `id` FROM Contests;";
	$result=$db->query($query) or die($db->error);
	while ( $row = mysqli_fetch_array($result) ) {
		$ContestId=$row['id'];

		$query="SELECT `id` FROM Problems WHERE `ContestId`=$ContestId";
		$Problems=$db->query($query) or die($db->error);

		$query="SELECT `ContestantId` FROM Participations WHERE `ContestId`=$ContestId";
		$ContestantsResult=$db->query($query) or die($db->error);

		$n=0;
		$Contestants=[];
		while($Contestants[$n]=mysqli_fetch_array($ContestantsResult)['ContestantId'])$n++;
		
		while($Prow = mysqli_fetch_array($Problems)){
			$ProblemId=$Prow['id'];
			$q=mt_rand(0,$n);
			//~ echo "$ProblemId $q\n";
			for($i=0;$i<$q;$i++) {
				if(mt_rand(1,10)>=7) continue;
				
				$CommentLength=mt_rand(0,200);
				$Comment='';
				for($j=0;$j<$CommentLength;$j++) $Comment .= $CharactersList[mt_rand(0,$CharactersNumber)];
				
				$query="INSERT INTO `Corrections` (ProblemId,ContestantId,mark,comment,UserId) VALUES
						($ProblemId,$Contestants[$i],".mt_rand(0,7).",'".$Comment."',".$Users[mt_rand(0,$qU-1)].");";
				$db->query($query) or die($db->error);
			}
		}
		
	}

	echo "Table Corrections Populated.\n";
}

CreateDatabase();

PopulateUsers();
PopulateAdministrators();
PopulateContests();
PopulatePermissions();
PopulateContestants();
PopulateParticipations();
PopulateProblems();
PopulateCorrections();

echo "THE DATABASE IS COMPLETELY INITIALIZED!\n";

?>
