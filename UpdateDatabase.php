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

if( AddContestantsEmailColumn() ) {
	if( AddParticipationEmailBoolean() ) {
		echo 'Database has been updated successfully!'.NewLine();
	}
}