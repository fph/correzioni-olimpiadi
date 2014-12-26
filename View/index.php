<?php
global $v_admin;
?>


<h2 class="PageTitle">
	Benvenuti!
</h2>

<?php 
$links=[ ['name'=>'Gare', 'redirect'=>['url'=>'ViewContests']] ];
if ($v_admin==1) $links[]=['name'=>'Amministrazione', 'redirect'=>['url'=>'AdminAdministration']];
InsertLinkTable( $links ); 
?>
