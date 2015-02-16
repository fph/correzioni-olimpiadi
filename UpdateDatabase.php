<?php
require_once "Utilities.php";
SuperRequire_once("General","sqlUtilities.php");


function AddContestantsEmailColumn(){
	$db=OpenDbConnection();
	$query='ALTER TABLE `Contestants` ADD COLUMN `email` varchar('.ContestantEmail_MAXLength.') NOT NULL';
	Query($db, $query);
	$db->close();
}

AddContestantsEmailColumn();
