<?php
global $v_contest;
?>

<h2 class='PageTitle'>
	<span>
	<?=$v_contest['name']?>
	</span>
	<span>
	<?php 
	if (!is_null($v_contest['date'])) {?>
		- <?=GetItalianDate($v_contest['date'])?>
		<?php
	} ?>
	</span>
	<span>
<?php
	if (!is_null($v_contest['SolutionsZip'])) { ?>
		<a href='../Modify/ManageFiles.php?type=ContestZip&ContestId=<?=$v_contest['id']?>' download><img src='../View/Images/DownloadZip.png' alt='Scarica tutti gli elaborati dei partecipanti'></a>
<?php } ?>
	</span>
</h2>

<?php
InsertDom('LinkTable', [
	['name'=>'Partecipanti', 'redirect'=>['url'=>'ViewContestantsOfAContest', 'parameters'=>['ContestId'=>$v_contest['id']] ]],
	['name'=>'Problemi', 'redirect'=>['url'=>'ViewProblemsOfAContest', 'parameters'=>['ContestId'=>$v_contest['id']] ]],
	['name'=>'Classifica', 'redirect'=>['url'=>'ViewRankingOfAContest', 'parameters'=>['ContestId'=>$v_contest['id']] ]]
]);
?>
