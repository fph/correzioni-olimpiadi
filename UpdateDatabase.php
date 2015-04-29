<?php
require_once 'Utilities.php';
SuperRequire_once('General','sqlUtilities.php');


function AddContestantsEmailColumn(){
	if( !defined('ContestantEmail_MAXLength') or !defined('EmailAddress') ) {
		echo 'Before updating, Constants.php must be modified (defining \'ContestantEmail_MAXLength\' and \'EmailAddress\').'.NewLine();
		return false;
	}
	
	$db=OpenDbConnection();
	
	$ColumnExists=OneResultQuery($db, QuerySelect('information_schema.COLUMNS', ['TABLE_SCHEMA'=>'CorOli', 'TABLE_NAME'=>'Contestants', 'COLUMN_NAME'=>'email']));
	if( is_null($ColumnExists) ) {
		$query='ALTER TABLE `Contestants` ADD COLUMN `email` varchar('.ContestantEmail_MAXLength.') NOT NULL';
		Query($db, $query);
		
		echo 'The \'email\' column has been added in the \'Contestants\' table.'.NewLine();
	}
	else {
		echo 'The \'email\' column already exists in the \'Contestants\' table.'.NewLine();
	}
	$db->close();
	
	return true;
}

function AddParticipationEmailBoolean(){
	$db=OpenDbConnection();
	$ColumnExists=OneResultQuery($db, QuerySelect('information_schema.COLUMNS', ['TABLE_SCHEMA'=>'CorOli', 'TABLE_NAME'=>'Participations', 'COLUMN_NAME'=>'email']));
	if( is_null($ColumnExists) ) {
		$query='ALTER TABLE `Participations` ADD COLUMN `email` Boolean NOT NULL DEFAULT false';
		Query($db, $query);
		echo 'The \'email\' column has been added in the \'Participations\' table.'.NewLine();
	}
	else {
		echo 'The \'email\' column already exists in the \'Participations\' table.'.NewLine();
	}
	
	$db->close();
	
	return true;
}

function AddUserRoleColumn(){
	$db=OpenDbConnection();
	
	$ColumnExists=OneResultQuery($db, QuerySelect('information_schema.COLUMNS', ['TABLE_SCHEMA'=>'CorOli', 'TABLE_NAME'=>'Users', 'COLUMN_NAME'=>'role']));
	
	if( is_null($ColumnExists) ) {
		$query='ALTER TABLE `Users` ADD COLUMN `role` int NOT NULL DEFAULT 0';
		Query($db, $query);
		echo 'The \'role\' column has been added in the \'Users\' table.'.NewLine();
		
		$AllAdministrators=ManyResultQuery($db, QuerySelect('Administrators'));
		foreach($AllAdministrators as $admin) {
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

if( AddContestantsEmailColumn() ) {
	if( AddParticipationEmailBoolean() ) {
		if( AddUserRoleColumn() ) {
			echo 'Database has been updated successfully!'.NewLine();
		}
	}
}

