<?php
require_once '../Utilities.php';
SuperRequire_once('General', 'TemplateCreation.php');
SuperRequire_once('General', 'sqlUtilities.php');

$db = OpenDbConnection();
$v_StupidParticipation = OneResultQuery($db, QuerySelect('Participations', ['id'=>3]));
$db->close();

TemplatePage('LoremIpsum', ['Index'=>'index.php', 'Lorem ipsum'=>'LoremIpsum.php']);

?>
