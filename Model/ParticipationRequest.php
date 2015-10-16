<?php
require_once '../Utilities.php';

SuperRequire_once('General', 'sqlUtilities.php');
SuperRequire_once('General', 'TemplateCreation.php');

$db = OpenDbConnection();

// FIXME: È lento farsi restituire tutte le gare poi scremare, ma è l'unico modo
// 		  se si vuole evitare di scrivere a mano la query.
$AllContests = ManyResultQuery($db, QuerySelect('Contests'));

$v_ActiveContests = [];
foreach ($AllContests as $contest) {
	$Deadline = new Datetime($contest['date']);
	if ((new Datetime('now'))->setTime(0, 0, 0) <= $Deadline) {
		$v_ActiveContests []= $contest;
	}
}

$db->close();

TemplatePage('ParticipationRequest', [], 0);
?>
