<h2 class='pageTitle'>Richiesta di partecipazione</h2>
<div class='ParticipationRequestDiv'>
Seguendo le istruzioni date in questa pagina arriverai ad iscriverti ad uno stage delle olimpiadi di Matematica.
Per procedere è necessario che tu abbia un indirizzo email, che abbia già pronto il pdf con gli esercizi richiesti per l'ammissione e che, se sei un volontario, abbia anche preparato il pdf con la domanda d'ammissione.
Se dovessi avere qualunque problema con l'iscrizione, scrivi all'indirizzo mail@mail.com indicando chi sei e quale è il problema.
</div>


<div class='ParticipationRequestDiv'>
	Hai mai usato questo sito? 
	<select name='AlreadyRegistered' onchange='console.log(this.value)'>
		<option value='' style='display:none;'></option>
		<option value='1'>Sì</option>
		<option value='0'>No</option>
	</select>
</div>

<div class='ParticipationRequestDiv'>
Indica la mail che hai inserito l'ultima volta che hai usato il sito.
A tale mail ti verrà inviato un codice, che dovrai reinserire su questo sito, per mostrare di essere l'utente proprietario della mail.
<?php
$form = ['SubmitFunction'=>'SendCode(this)', 'SubmitText'=>'Invia codice di verifica', 'inputs'=>[
	['type'=>'email', 'title'=>'Indirizzo email', 'name'=>'email', 'placeholder'=>'user@domain.com']
]];

InsertDom('form', $form);
?>
</div>

<div class='ParticipationRequestDiv'>
Quando ti arriva la mail contenente il codice di verifica, inserisci tale codice in questa pagina (quindi non chiudere la pagina).
<!--
Se il codice non dovesse arrivarti entro una decina di minuti, riprova.
-->
<?php
$form = ['SubmitFunction'=>'CheckCode(this)', 'SubmitText'=>'Controlla il codice', 'inputs'=>[
	['type'=>'text', 'title'=>'Codice di verifica', 'name'=>'code']
]];

InsertDom('form', $form);
?>
</div>

<div class='ParticipationRequestDiv'>
	Compila il seguente questionario. I dati saranno trattati con la massima riservatezza ed usati unicamente per gestire le ammissioni allo stage ed il suo svolgimento. 

	<form id='ContestantInfo'>
		<fieldset>
			<legend>Dati personali</legend>
			<table><tbody>
				<tr>
					<td>
					<label for='NameInput'>Nome</label> 
					</td>
					<td>
						<input type='text' name='name' id='NameInput'>
					</td>
				</tr>
				<tr>
					<td>
						<label for='SurnameInput'>Cognome</label> 
					</td>
					<td>	
						<input type='text' name='surname' id='SurnameInput'>
					</td>
				</tr>
				<tr>
					<td>
					<label for='EmailInput'>Indirizzo email</label> 
					</td>
					<td>
						<input type='email' name='email' id='EmailInput'placeholder='user@domain.com'> 
					</td>
					<td>
						A questo indirizzo verranno mandati i risultati delle correzioni e verrà usato per comunicarti le informazioni riguardanti lo stage.
					</td>
				</tr>
			</tbody></table>
		</fieldset>
		
		<fieldset>
		<legend>Scuola</legend>
		<table><tbody>
			<tr>
				<td>
					<label for='SchoolInput'>Nome della scuola</label> 
				</td>
				<td>
					<input type='text' name='school' id='SchoolInput' placeholder='Liceo Scientifico Garibaldi'> <br>
				</td>
			</tr>
			<tr>
				<td>
					<label for='SchoolYearInput'>Anno di corso</label> 
				</td>
				<td>
					<select name='SchoolYear' id='SchoolYearInput'>
						<option value='' style='display:none;'></option>
						<option value='1'>Primo anno</option>
						<option value='2'>Secondo anno</option>
						<option value='3'>Terzo anno</option>
						<option value='4'>Quarto anno</option>
						<option value='5'>Quinto anno</option>
					</select>
				</td>
				<td>
					Indica l'anno di corso che stai per iniziare o quello che stai frequentando. Se frequenti un liceo classico, indica l'anno dall'inizio del ginnasio (es. quinto ginnasio coincide con secondo anno).
				</td>
			</tr>
		</tbody></table>
		</fieldset>
	</form>
</div>

<!--
<div class='FormContainer'>
	<form class='UserForm' id='LoginForm' method='POST' action='Login.php'>
		<table>
		<tr>
			<th> Username</th>
			<th> Password</th>
			<th> </th>
		</tr>
		<tr>
			<td> <input type='text' name='username'> </td>
			<td> <input type='password' name='password'> </td>
			<td> <input type='submit' value='Login'> </td>
		</tr>
		</table>
	</form>
</div>
-->
