
<h2 class='PageTitle'>
	Amministrazione
</h2>

<?php
InsertDom('LinkTable', [
	['name'=>'Partecipanti', 'redirect'=>['url'=>'AdminContestants']],
	['name'=>'Correttori', 'redirect'=>['url'=>'AdminUsers']],
	['name'=>'Gare', 'redirect'=>['url'=>'AdminContests']],
	['name'=>'Statistiche', 'redirect'=>['url'=>'AdminStatistics']]
]);
?>