<?php
global $v_admin, $v_SuperAdmin;
?>


<h2 class='PageTitle'>
	Benvenuti!
</h2>

<?php 
$links = [ ['name'=>'Gare', 'redirect'=>['url'=>'ViewContests']] ];
if ($v_admin == 1) $links []= ['name'=>'Amministrazione', 'redirect'=>['url'=>'AdminAdministration']];
if ($v_SuperAdmin == 1) $links []= ['name'=>'Configurazioni', 'redirect'=>['url'=>'Configurations']];
InsertDom('LinkTable',  $links); 
?>
