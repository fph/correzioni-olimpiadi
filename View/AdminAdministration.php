
<script>
	function RedirectContestants() {
		document.location="AdminContestants.php";
	}
	
	function RedirectUsers() {
		document.location="AdminUsers.php";
	}
	
	function RedirectContests() {
		document.location="AdminContests.php";
	}
</script>

<h2 class="pageTitle">
	Amministrazione
</h2>

<table class="TableLink">
	<tr class="trlink" onclick=RedirectContestants()>
	<td>Partecipanti</td>
	</tr>
	<tr class="trlink" onclick=RedirectUsers()>
	<td>Correttori</td>
	</tr>
	<tr class="trlink" onclick=RedirectContests()>
	<td>Gare</td>
	</tr>
</table>
