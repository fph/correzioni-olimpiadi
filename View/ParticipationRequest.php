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
	['type'=>'text', 'title'=>'Indirizzo email', 'name'=>'mail', 'placeholder'=>'user@domain.com']
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
			<label for='NameInput'>Nome</label> <input type='text' name='name' id='NameInput'> <br>
			<label for='SurnameInput'>Cognome</label> <input type='text' name='surname' id='SurnameInput'> <br>
			
			<label for='EmailInput'>Indirizzo email</label> 
			<input type='text' name='email' id='EmailInput'placeholder='user@domain.com'> A questo indirizzo verranno mandati i risultati delle correzioni del tuo elaborato e verrà usato per comunicare con te riguardo l'organizzazione dello stage nel caso in cui tu venga ammesso.
		</fieldset>
		
		<fieldset>
		<legend>Scuola</legend>
		<label for='SchoolInput'>Nome della scuola</label> 
		<input type='text' name='school' id='SchoolInput'> <br>
		
		<label for='SchoolYearInput'>Indirizzo email</label> 
		<select name='SchoolYear' id='SchoolYearInput'>
			<option value='' style='display:none;'></option>
			<option value='1'>Primo anno</option>
			<option value='2'>Secondo anno</option>
			<option value='3'>Terzo anno</option>
			<option value='4'>Quarto anno</option>
			<option value='5'>Quinto anno</option>
		</select>
		Se stai per iniziare il quarto anno allora indica il quarto anno. Se stai frequentando la seconda, allora indica il secondo anno. Se frequenti un liceo classico, indica l'anno dall'inizio del ginnasio (quindi quinto ginnasio coincide con secondo anno).
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
