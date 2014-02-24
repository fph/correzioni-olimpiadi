<?php
global $v_contestants;
?>

<h2 class='PageTitle'>
	Partecipanti
</h2>

<h3 class='PageSubtitle'>
	Lista dei partecipanti
</h3>


<?php

$columns=[];
$columns[]=['id'=>'surname', 'name'=>'Cognome', 'class'=>['SurnameColumn'], 'order'=>1];
$columns[]=['id'=>'name', 'name'=>'Nome', 'class'=>['NameColumn']];
$columns[]=['id'=>'school', 'name'=>'Scuola', 'class'=>['SchoolColumn']];

$rows=[];
foreach($v_contestants as $contestant) {
	$row=[
	'values'=>['surname'=>$contestant['surname'], 'name'=>$contestant['name'], 'school'=>$contestant['school']], 
	'redirect'=>['ContestantId'=>$contestant['id'] ] ];
	$rows[]=$row;
} 

$table=['columns'=>$columns, 'rows'=>$rows, 'redirect'=>'AdminContestantInformation', 'id'=>'AdminContestantsTable'];

InsertTable( $table );
?>


<h3 class='PageSubtitle'>
	Aggiungi un partecipante
</h3>

<div class='FormContainer'>
	<table>
	<tr>
		<th> Cognome </th>
		<th> Nome </th>
		<th> Scuola </th>
		<th> </th>
	</tr>
	<tr>
		<td> <input type="text" name="surname" id="SurnameInput"> </td>
		<td> <input type="text" name="name" id="NameInput"> </td>
		<td> <input type="text" name="school" id="SchoolInput"> </td>
		<td> <input type="button" value="Aggiungi" onclick=AddContestantRequest()> </td>
	</tr>
	</table>
</div>
