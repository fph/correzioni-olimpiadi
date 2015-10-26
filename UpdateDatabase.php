<?php
require_once 'Utilities.php';
SuperRequire_once('General', 'sqlUtilities.php');


function AddContestantsEmailColumn() {
	if (!defined('ContestantEmail_MAXLength') or !defined('EmailAddress')) {
		echo 'Before updating, Constants.php must be modified (defining \'ContestantEmail_MAXLength\' and \'EmailAddress\').'.NewLine();
		return false;
	}
	
	$db = OpenDbConnection();
	
	$ColumnExists = OneResultQuery($db, QuerySelect('information_schema.COLUMNS', ['TABLE_SCHEMA'=>dbName, 'TABLE_NAME'=>'Contestants', 'COLUMN_NAME'=>'email']));
	if (is_null($ColumnExists)) {
		$query = 'ALTER TABLE `Contestants` ADD COLUMN `email` varchar('.ContestantEmail_MAXLength.') NOT NULL';
		Query($db, $query);
		
		echo 'The \'email\' column has been added in the \'Contestants\' table.'.NewLine();
	}
	else {
		echo 'The \'email\' column already exists in the \'Contestants\' table.'.NewLine();
	}
	
	$db->close();
	return true;
}

function AddParticipationEmailBoolean() {
	$db = OpenDbConnection();
	$ColumnExists = OneResultQuery($db, QuerySelect('information_schema.COLUMNS', ['TABLE_SCHEMA'=>dbName, 'TABLE_NAME'=>'Participations', 'COLUMN_NAME'=>'email']));
	if (is_null($ColumnExists)) {
		$query = 'ALTER TABLE `Participations` ADD COLUMN `email` Boolean NOT NULL DEFAULT false';
		Query($db, $query);
		echo 'The \'email\' column has been added in the \'Participations\' table.'.NewLine();
	}
	else {
		echo 'The \'email\' column already exists in the \'Participations\' table.'.NewLine();
	}
	
	$db->close();
	return true;
}

function AddUserRoleColumn() {
	$db = OpenDbConnection();
	
	$ColumnExists = OneResultQuery($db, QuerySelect('information_schema.COLUMNS', ['TABLE_SCHEMA'=>dbName, 'TABLE_NAME'=>'Users', 'COLUMN_NAME'=>'role']));
	
	if (is_null($ColumnExists)) {
		$query = 'ALTER TABLE `Users` ADD COLUMN `role` int NOT NULL DEFAULT 0';
		Query($db, $query);
		echo 'The \'role\' column has been added in the \'Users\' table.'.NewLine();
		
		$AllAdministrators = ManyResultQuery($db, QuerySelect('Administrators'));
		foreach ($AllAdministrators as $admin) {
			Query($db, QueryUpdate('Users', ['id'=>$admin['UserId']], ['role'=>1]));
		}
		echo 'All administrators have been imported in the \'role\' column.'.NewLine();
		
		//At least a SuperAdmin must exist
		Query($db, QueryUpdate('Users', ['username'=>'dario2994'], ['role'=>2]));
		
		Query($db, 'DROP TABLE `Administrators`');
		echo 'The old \'Administrators\' table has been deleted.'.NewLine();
	}
	else {
		echo 'The \'role\' column already exists in the \'Users\' table.'.NewLine();
	}
	
	$db->close();
	return true;
}

function ChangeMarkToFloat() {
	$db = OpenDbConnection();
	
	$query = 'SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name=\'Corrections\' AND COLUMN_NAME=\'mark\'';
	$DataType = OneResultQuery($db, $query)['DATA_TYPE'];
	
	if ($DataType != 'decimal') {
		$query = 'ALTER TABLE `Corrections` CHANGE COLUMN mark OldMark int';
		Query($db, $query);

		// decimal(3, 1) means numbers as 23.2, 7.3 etc...
		// For sums, decimal is better than float (it is exact).
		$query = 'ALTER TABLE `Corrections` ADD COLUMN mark decimal(3, 1)';
		Query($db, $query);

		$query = 'UPDATE `Corrections` SET mark=OldMark';
		Query($db, $query);

		$query = 'ALTER TABLE `Corrections` DROP COLUMN OldMark';
		Query($db, $query);
		
		echo 'Now mark is a floating number.'.NewLine();
	}
	else {
		echo 'The mark is already a floating number.'.NewLine();
	}
	
	$db->close();
	return true;
}

function ChangeCommentToText() {
	$db = OpenDbConnection();

	$query = 'SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name=\'Corrections\' AND COLUMN_NAME=\'comment\'';
	$DataType = OneResultQuery($db, $query)['DATA_TYPE'];
	
	if ($DataType != 'text') {
		$query = 'ALTER TABLE `Corrections` MODIFY COLUMN comment TEXT DEFAULT \'\'';
		Query($db, $query);
		
		echo 'Now comment column is TEXT type.'.NewLine();
	}
	else {
		echo 'The comment is already TEXT.'.NewLine();
	}
	
	$db->close();
	return true;
}

function AddLastOlympicYearColumn() {
	$db = OpenDbConnection();
	
	$ColumnExists = OneResultQuery($db, QuerySelect('information_schema.COLUMNS', ['TABLE_SCHEMA'=>dbName, 'TABLE_NAME'=>'Contestants', 'COLUMN_NAME'=>'LastOlympicYear']));
	if (is_null($ColumnExists)) {
		$query = 'ALTER TABLE `Contestants` ADD COLUMN `LastOlympicYear` int NOT NULL DEFAULT 2050';
		Query($db, $query);
		
		echo 'The \'LastOlympicYear\' column has been added in the \'Contestants\' table.'.NewLine();
	}
	else {
		echo 'The \'LastOlympicYear\' column already exists in the \'Contestants\' table.'.NewLine();
	}
	
	$db->close();
	return true;
}

function AddFilenamesColumns() {
	$db = OpenDbConnection();
	
	$ColumnExists = OneResultQuery($db, QuerySelect('information_schema.COLUMNS', ['TABLE_SCHEMA'=>dbName, 'TABLE_NAME'=>'Participations', 'COLUMN_NAME'=>'solutions']));
	if (is_null($ColumnExists)) {
		$query = 'ALTER TABLE `Participations` ADD COLUMN `solutions` varchar(31) DEFAULT NULL';
		Query($db, $query);
		
		echo 'The \'solutions\' column has been added in the \'Participations\' table.'.NewLine();
	}
	else {
		echo 'The \'solutions\' column already exists in the \'Participations\' table.'.NewLine();
	}
	
	$ColumnExists = OneResultQuery($db, QuerySelect('information_schema.COLUMNS', ['TABLE_SCHEMA'=>dbName, 'TABLE_NAME'=>'Contests', 'COLUMN_NAME'=>'SolutionsZip']));
	if (is_null($ColumnExists)) {
		$query = 'ALTER TABLE `Contests` ADD COLUMN `SolutionsZip` varchar(31) DEFAULT NULL';
		Query($db, $query);
		
		echo 'The \'SolutionsZip\' column has been added in the \'Contests\' table.'.NewLine();
	}
	else {
		echo 'The \'SolutionsZip\' column already exists in the \'Contests\' table.'.NewLine();
	}
	
	$db->close();
	return true;
}


function CreateVerificationCodesTable() {
	$db = OpenDbConnection();
	
	$query=
	'CREATE TABLE IF NOT EXISTS `VerificationCodes` (
		`email` varchar('.ContestantEmail_MAXLength.') NOT NULL,
		`code` char(12) NOT NULL,
		`timestamp` timestamp NOT NULL,
		
		PRIMARY KEY (`email`)
	) ENGINE=InnoDB';
	Query($db, $query);
	echo 'The \'VerificationCodes\' table has been created (if it already existed nothing has been changed).'.NewLine();
	
	$db->close();
	return true;
}

function AddContestantsSchoolCityColumn() {
	if (!defined('ContestantSchoolCity_MAXLength')) {
		echo 'Before updating, Constants.php must be modified (defining \'ContestantSchoolCity_MAXLength\').'.NewLine();
		return false;
	}
	
	$db = OpenDbConnection();
	
	$ColumnExists = OneResultQuery($db, QuerySelect('information_schema.COLUMNS', ['TABLE_SCHEMA'=>dbName, 'TABLE_NAME'=>'Contestants', 'COLUMN_NAME'=>'SchoolCity']));
	if (is_null($ColumnExists)) {
		$query = 'ALTER TABLE `Contestants` ADD COLUMN `SchoolCity` varchar('.ContestantSchoolCity_MAXLength.') NOT NULL DEFAULT \'\'';
		Query($db, $query);
		
		echo 'The \'SchoolCity\' column has been added in the \'Contestants\' table.'.NewLine();
	}
	else {
		echo 'The \'SchoolCity\' column already exists in the \'Contestants\' table.'.NewLine();
	}
	
	$db->close();
	return true;
}

if (!AddContestantsEmailColumn()) {
	die('Error while adding contestant email column');
}

if (!AddParticipationEmailBoolean()) {
	die('Error while adding email column in `Participation` table');
}

if (!AddUserRoleColumn()) {
	die('Error while adding user role column');
}

if (!ChangeMarkToFloat()) {
	die('Error while changing mark column from INTEGER to FLOAT');
}

if (!ChangeCommentToText()) {
	die('Error while changing mark column from VARCHAR to TEXT');
}

if (!AddLastOlympicYearColumn()) {
	die('Error while changing mark column from VARCHAR to TEXT');
}

if (!AddFilenamesColumns()) {
	die('Error while changing mark column from VARCHAR to TEXT');
}

if (!CreateVerificationCodesTable()) {
	die('Error while creating VerificationCodes table');
}

if (!AddContestantsSchoolCityColumn()) {
	die('Error while adding SchoolCity column');
}

echo 'Database has been updated successfully!'.NewLine();

