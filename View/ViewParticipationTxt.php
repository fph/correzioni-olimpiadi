<?php
global $v_corrections, $v_contestant, $v_contest;
?>

<!--
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
</h2>

<h3 class="PageSubtitle">
	<span class='contestant_title'>
		<?=$v_contestant['surname']?> <?=$v_contestant['name']?>
	</span>
</h3>
-->

Caro/a <?=$v_contestant['name']?>,<br>
questo e' il verbale di correzione dei tuoi esercizi:<br><br>

<?php
foreach($v_corrections as $correction) {
	?>
	<?=$correction['problem']['name']?> 
	<?php
	if($correction['done']) { ?>
		<?=$correction['mark']?> [<?=$correction['username']?>] <?=$correction['comment']?>
	<?php }
	else { ?>
		#
	<?php }	?>
	<br>
	<?php
}
?>
