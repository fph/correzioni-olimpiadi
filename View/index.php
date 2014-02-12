<?php
global $v_contest;
?>

<script>
	function RedirectContests() {
		document.location="ViewContests.php";
	}
	function RedirectContestants() {
		document.location="ViewContestants.php";
	}
</script>

<h2 class="pageTitle">
	Benvenuti!
</h2>

<table class="TableLink">
	<tr class="trlink" id="LinkToContests" onclick=RedirectContests()>
	<td>Contests</td>
	</tr>
	
	<tr class="trlink" id="LinkToContestants" onclick=RedirectContestants()>
	<td>Contestants</td>
	</tr>
</table>
