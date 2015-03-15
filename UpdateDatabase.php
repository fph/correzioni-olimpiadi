<?php
require_once "Utilities.php";
SuperRequire_once("General","sqlUtilities.php");


function AddContestantsEmailColumn(){
	$db=OpenDbConnection();
	
	$ColumnExists=OneResultQuery($db, QuerySelect('information_schema.COLUMNS', ['TABLE_SCHEMA'=>'CorOli', 'TABLE_NAME'=>'Contestants', 'COLUMN_NAME'=>'email']));
	if( is_null($ColumnExists) ) {
		$query='ALTER TABLE `Contestants` ADD COLUMN `email` varchar('.ContestantEmail_MAXLength.') NOT NULL';
		Query($db, $query);
	}
	$db->close();
}

function AddParticipationEmailBoolean(){
	$db=OpenDbConnection();
	$ColumnExists=OneResultQuery($db, QuerySelect('information_schema.COLUMNS', ['TABLE_SCHEMA'=>'CorOli', 'TABLE_NAME'=>'Participations', 'COLUMN_NAME'=>'email']));
	if( is_null($ColumnExists) ) {
		$query='ALTER TABLE `Participations` ADD COLUMN `email` Boolean NOT NULL DEFAULT false';
		Query($db, $query);
	}
	$db->close();
}

AddContestantsEmailColumn();
AddParticipationEmailBoolean();
