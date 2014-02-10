<?php
	global $v_corrections, $v_contestant, $v_contest;
	foreach ($v_corrections as $cor) {
		if ($cor==NULL) echo "Non ancora corretto <br>";
		else echo "Id del problema: ".$cor["ProblemId"].", punteggio: ".$cor["mark"]."<br>";
	}
?>
