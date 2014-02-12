<?php
global $v_contest;
?>

<script>
	function RedirectContestants(contestId) {
		document.location="ViewContestantsOfAContest.php?contestId="+contestId;
	}
	function RedirectProblems(contestId) {
		document.location="ViewCProblemsOfAContest.php?contestId="+contestId;
	}
</script>

<div id="contestInfo">
	<?php
		echo $v_contest['name'];
	?>
</div>


<div id="LinkToContestants" onclick=RedirectContestants(<?php echo $v_contest['id']; ?>)>
	Contestants
</div>

<div id="LinkToProblems" onclick=RedirectProblems(<?php echo $v_contest['id'] ?>)>
	Problems
</div>

<div id="LinkToStatistics" onclick=RedirectContestants(<?php echo $v_contest['id'] ?>)>
	Statistics
</div>
