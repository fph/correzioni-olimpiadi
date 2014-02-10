<?php
global $v_corrections, $v_contestant, $v_contest_name;
?>

<div id="contest">
<?php
	echo $v_contest_name."<br>";
?>
</div>

<div id="contestant">
<?php
	echo $v_contestant["name"]." ".$v_contestant["surname"]."<br>";
?>
</div>

<?php
foreach ($v_corrections as $cor) {
	echo $cor["Problem"]." ";
	if ($cor["done"]) {
		echo $cor["mark"]." ".$cor["comment"]." ".$cor["User"]."<br>";
	}
	else echo "Non ancora corretto <br>";
}
?>
