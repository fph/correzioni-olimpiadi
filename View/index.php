<?php
global $v_admin;
?>


<h2 class="pageTitle">
	Benvenuti!
</h2>

<table class="TableLink">
	<tr class="trlink" id="LinkToContests" onclick="Redirect('ViewContests')">
	<td>Gare</td>
	</tr>
	
	<?php 
	if ($v_admin==1) { 
		?>	
		<tr class="trlink" id="LinkToAdministration" onclick="Redirect('AdminAdministration')">
		<td>Amministrazione</td>
		</tr>
		<?php
	} ?>
</table>
