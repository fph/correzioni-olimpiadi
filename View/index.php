<?php
global $v_admin;
?>

<script>
	function RedirectContests() {
		document.location="ViewContests.php";
	}
	function RedirectAdministration() {
		document.location="AdminAdministration.php";
	}
</script>

<h2 class="pageTitle">
	Benvenuti!
</h2>

<table class="TableLink">
	<tr class="trlink" id="LinkToContests" onclick=RedirectContests()>
	<td>Gare</td>
	</tr>
	
	<?php 
	if ($v_admin==1) { 
		?>	
		<tr class="trlink" id="LinkToAdministration" onclick=RedirectAdministration()>
		<td>Amministrazione</td>
		</tr>
		<?php
	} ?>
</table>
