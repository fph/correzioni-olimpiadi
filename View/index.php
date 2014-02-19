<?php
global $v_admin;
?>


<h2 class="PageTitle">
	Benvenuti!
</h2>

<table class="LinkTable">
	<tr class="trlink" onclick="Redirect('ViewContests')">
	<td>Gare</td>
	</tr>
	
	<?php 
	if ($v_admin==1) { 
		?>	
		<tr class="trlink" onclick="Redirect('AdminAdministration')">
		<td>Amministrazione</td>
		</tr>
		<?php
	} ?>
</table>
