<?php 
	global $v_ActiveContests;
?>

<h2 class='pageTitle'>Richiesta di partecipazione</h2>
<div class='ParticipationRequestDiv'>
Seguendo le istruzioni date in questa pagina arriverai ad iscriverti ad uno stage delle olimpiadi di Matematica.
Per procedere è necessario che tu abbia un indirizzo email, che abbia già pronto il pdf con gli esercizi richiesti per l'ammissione e che, se sei un volontario, abbia anche preparato il pdf con la domanda d'ammissione.
Se dovessi avere qualunque problema con l'iscrizione, scrivi all'indirizzo <em>mail@mail.com</em> indicando chi sei e quale è il problema.
<!--
	FIXME: Mettere un vero indirizzo al posto di mail@mail.com
-->
</div>

<div id='TransitionContainer'>
	<div class='TransitionButton hidden' id='PreviousButton' onclick='PreviousTransition()'>
		Indietro
	</div>
	<div class='TransitionButton hidden' id='NextButton' onclick='NextTransition()'>
		Avanti
	</div>
	
	
	<div class='TransitionDiv DuringTransition' id='OldUserDiv'>
		<p>
			Se hai mai usato questo sito oppure hai provato a partecipare (indifferentemente dall'esito della richiesta) al <em>Winter Camp 2015</em> o al <em>Senior 2015</em> allora indica che sei già registrato.
			Se invece non hai mai usato questo sito e non hai mandato gli esercizi per nessuno dei due stage precedenti allora indica che non sei registrato.
		</p>
		Sei già registrato su questo sito? 
		<select name='AlreadyRegistered' onchange='SetOldUser(this.value)'>
			<option value='' style='display:none;'></option>
			<option value='1'>Sì</option>
			<option value='0'>No</option>
		</select>
	</div>
	
	<div class='TransitionDiv BeforeTransition' id='SendCodeDiv'>
		<p class='NewUser'>
			Inserisci il tuo indirizzo email. L'email sarà usata per comunicarti i risultati delle correzioni e tutte le informazioni riguardanti lo stage.
		</p>
		<p class='OldUser'>
			Indica <b>lo stesso indirizzo email</b> che hai inserito l'ultima volta che hai usato il sito. Se non hai più accesso all'indirizzo che hai usato la volta scorsa oppure vuoi cambiarlo, scrivi a <em>mail@mail.com</em> chi sei (preferibilmente dimostrando in qualche modo di essere chi dici di essere) e quale indirizzo email vorresti usare. 
			Se invece non ricordi quale indirizzo avevi usato, puoi provare ad inviare il codice a tutti gli indirizzi possibili e il sistema invierà il codice solamente all'indirizzo che avevi usato.
		</p>
		<p>
		A tale indirizzo ti verrà inviato un codice, che dovrai reinserire su questo sito, per mostrare di essere l'utente proprietario della mail.
		</p>
		<?php
		$form = ['id'=>'SendCodeForm','SubmitFunction'=>'SendCode(this.elements)', 'SubmitText'=>'Invia codice di verifica', 'inputs'=>[
			['type'=>'hidden', 'name'=>'OldUser'], 
			['type'=>'email', 'title'=>'Indirizzo email', 'name'=>'email', 'placeholder'=>'user@domain.com']
		]];

		InsertDom('form', $form);
		?>
	</div>

	<div class='TransitionDiv BeforeTransition' id='CheckCodeDiv'>
		<p>
			Quando ti arriva la mail contenente il codice di verifica, inserisci tale codice in questa pagina (quindi non chiudere la pagina).
		</p>
		<!--
		Se il codice non dovesse arrivarti entro una decina di minuti, riprova.
		-->
		<?php
		$form = ['id'=>'CheckCodeForm', 'SubmitFunction'=>'CheckCode(this.elements)', 'SubmitText'=>'Controlla il codice', 'inputs'=>[
			['type'=>'hidden', 'name'=>'OldUser'],
			['type'=>'text', 'title'=>'Codice di verifica', 'name'=>'code'],
			['type'=>'hidden', 'name'=>'email']
		]];

		InsertDom('form', $form);
		?>
	</div>

	<div class='TransitionDiv BeforeTransition' id='ContestantInfoDiv'>
		<p class='NewUser'>Compila il seguente questionario.</p>
		<p class='OldUser'>Conferma i seguenti dati oppure modificali se non sono corretti.</p>
		<p>
			I dati saranno trattati con la massima riservatezza ed usati unicamente per gestire le ammissioni allo stage ed il suo svolgimento. 
		</p>
		<form id='ContestantInfo' class='BigForm' onsubmit='CreateContestant(this.elements); return false'>
			<input type='hidden' name='OldUser'>
			<input type='hidden' name='code'>
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
						<input type='email' name='email' id='EmailInput' placeholder='user@domain.com' disabled='disabled'> 
					</td>
					<td>
						A questo indirizzo verranno mandati i risultati delle correzioni e verrà usato per comunicarti le informazioni riguardanti lo stage.
					</td>
				</tr>
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
						Indica l'anno di corso che devi iniziare (se è Estate) o quello che stai frequentando. Se frequenti un liceo classico, indica l'anno dall'inizio del ginnasio (es. quinto ginnasio coincide con secondo anno).
					</td>
				</tr>
			</tbody></table>
			</fieldset>
			<input type='submit' value='Registra i miei dati'>
		</form>
		
	</div>

	<div class='TransitionDiv BeforeTransition' id='ParticipationInfoDiv'>
		<form id='ParticipationInfo' enctype='multipart/form-data' class='BigForm' onsubmit='CreateParticipation(this); return false'>
			<input type='hidden' name='ContestantId'>
			<input type='hidden' name='code'>
			<fieldset>
			<legend>Stage</legend>
			<table><tbody>
				<tr>
					<td>
						<label for='StagesNumberInput'>Numero di stage</label> 
					</td>
					<td>
						<input type='number' min='0' step='1' name='StagesNumber' id='StagesNumberInput'>
					</td>
					<td>
						Indica a quanti stage a Pisa (senior, winter camp o preIMO) hai già partecipato.
					</td>
				</tr>
				<tr>
					<td>
						<label for='ContestIdInput'>Nome stage o tipo di esercizi</label> 
					</td>
					<td>
						<select name='ContestId' id='ContestIdInput'>
							<option value='' style='display:none;'></option>
<?php
	foreach ($v_ActiveContests as $contest) {?>
							<option value='<?=$contest['id']?>'><?=$contest['name']?></option>
<?php } ?>
						</select>
					</td>
					<td>
						Indica a quale stage vuoi partecipare e, se necessario, quali esercizi hai dovuto risolvere.
					</td>
				</tr>
				<tr>
					<td>
						<label for='PaidVolunteerInput'>Spesato o volontario</label> 
					</td>
					<td>
						<select name='PaidVolunteer' id='PaidVolunteerInput' onchange='ChangingVolunteer(this.value)'>
							<option value='' style='display:none;'></option>
							<option value='paid'>Spesato</option>
							<option value='volunteer'>Volontario</option>
						</select>
					</td>
					<td>
						Spesato vuol dire che sei tra coloro che avranno vitto e alloggio pagati dall'organizzazione.
					</td>
				</tr>
				<tr>
					<td>
						<label for='SolutionsInput'>Esercizi per l'ammissione</label> 
					</td>
					<td>
						<input type='file' accept='.pdf' name='solutions' id='SolutionsInput'>
					</td>
					<td>
						Devi uploadare un documento in pdf, di dimensione minore di 10mb, contenente le tue soluzioni agli esercizi d'ammissione.
					</td>
				</tr>
				<tr class='hidden'>
					<td>
						<label for='VolunteerRequestInput'>Domanda di partecipazione</label> 
					</td>
					<td>
						<input type='file' accept='.pdf' name='VolunteerRequest' id='VolunteerRequestInput'>
					</td>
					<td>
						Devi uploadare un documento in pdf, di dimensione minore di 10mb, contenente la richiesta di partecipazione come volontario.
					</td>
				</tr>
			</tbody></table>
			
			</fieldset>
			<input type='submit' value='Invia richiesta di partecipazione'>
		</form>
	</div>

	<div class='TransitionDiv BeforeTransition' id='RegistrationEndDiv'>
		<p>
		La tua richiesta di partecipazione è stata salvata correttamente. 
		Il tuo elaborato sarà corretto e, qualora tu venga ammesso allo stage, sarai contattato dall'organizzazione.
		</p>
	</div>
</div>
