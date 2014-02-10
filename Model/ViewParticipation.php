<?php
	
	require_once "../Utilities.php";
	SuperRequire_once("General","sqlUtilities.php");
	SuperRequire_once("General","AskInformation.php");
	SuperRequire_once("General", "TemplateCreation.php");
	
	$v_corrections=AskParticipation(1);
	
	TemplatePage("ViewParticipation.php","ClassicUse_bar.php");
?>
