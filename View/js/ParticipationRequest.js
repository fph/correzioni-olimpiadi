var TransitionDivs = ['OldUserDiv', 'SendCodeDiv', 'CheckCodeDiv', 'ContestantInfoDiv', 'ParticipationInfoDiv', 'RegistrationEndDiv'];
var TransitionIterator = 0;
var LastTransitionIterator = 0;


function UpdateButtons() {
	if (TransitionIterator == TransitionDivs.length-1) {
		document.getElementById('PreviousButton').classList.add('hidden');
		document.getElementById('NextButton').classList.add('hidden');
		
		return;
	}
	
	if (TransitionIterator == 0) {
		document.getElementById('PreviousButton').classList.add('hidden');
	}
	else {
		document.getElementById('PreviousButton').classList.remove('hidden');
	}
	
	if (TransitionIterator == LastTransitionIterator) {
		document.getElementById('NextButton').classList.add('hidden');
	}
	else {
		document.getElementById('NextButton').classList.remove('hidden');
	}
}

function NextTransition() {
	var id1 = TransitionDivs[TransitionIterator];
	var id2 = TransitionDivs[TransitionIterator+1];
	TransitionIterator++;
	
	if (id1 != null) {
		document.getElementById(id1).classList.remove('DuringTransition');
		document.getElementById(id1).classList.add('AfterTransition');
	}
	
	if (id2 != null) {
		document.getElementById(id2).classList.remove('BeforeTransition');
		document.getElementById(id2).classList.add('DuringTransition');
	}
	
	if (TransitionIterator > LastTransitionIterator) LastTransitionIterator = TransitionIterator;
	
	UpdateButtons();
}

function PreviousTransition() {
	var id1 = TransitionDivs[TransitionIterator];
	var id2 = TransitionDivs[TransitionIterator-1];
	TransitionIterator--;
	
	if (id1 != null) {
		document.getElementById(id1).classList.remove('DuringTransition');
		document.getElementById(id1).classList.add('BeforeTransition');
	}
	
	if (id2 != null) {
		document.getElementById(id2).classList.remove('AfterTransition');
		document.getElementById(id2).classList.add('DuringTransition');
	}
	
	UpdateButtons();
}

function SetOldUser(val) {
	var AllNewUserThings = document.getElementsByClassName('NewUser');
	var AllOldUserThings = document.getElementsByClassName('OldUser');
	
	if (val == '0') {
		for (var i = 0; i < AllOldUserThings.length; i++) AllOldUserThings[i].classList.add('hidden');
		for (var i = 0; i < AllNewUserThings.length; i++) AllNewUserThings[i].classList.remove('hidden');
	}
	else if (val == '1') {
		for (var i = 0; i < AllNewUserThings.length; i++) AllNewUserThings[i].classList.add('hidden');
		for (var i = 0; i < AllOldUserThings.length; i++) AllOldUserThings[i].classList.remove('hidden');
	}
	
	document.getElementById('SendCodeForm').elements.namedItem('OldUser').value = val;
	document.getElementById('CheckCodeForm').elements.namedItem('OldUser').value = val;
	document.getElementById('ContestantInfo').elements.namedItem('OldUser').value = val;
	
	NextTransition();
}

function CodeSent(response) {
	if (response.type == 'good') {
		var email = response.data['email'];
		document.getElementById('CheckCodeForm').elements.namedItem('email').value = email;
		document.getElementById('ContestantInfo').elements.namedItem('email').value = email;
		
		NextTransition();
	}
}

function SendCode(inputs) {
	var email = inputs.namedItem('email').value;
	var OldUser = inputs.namedItem('OldUser').value;
	
	MakeAjaxRequest('../Modify/ManageVerificationCode.php', {email: email, OldUser: OldUser, type: 'send'}, CodeSent);
}

function CodeConfirmed(response) {
	if (response.type == 'good') {
		var ContestantInputs = document.getElementById('ContestantInfo').elements;
		var email = response.data['email'];
		var code = response.data['code'];
		ContestantInputs.namedItem('code').value = code;
		document.getElementById('ParticipationInfo').elements.namedItem('code').value = code;
		if (response.data['OldUser']) {
			var name = response.data['name'];
			var	surname = response.data['surname'];
			var school = response.data['school'];
			var SchoolYear = response.data['SchoolYear'];
			var ContestantId = response.data['ContestantId'];
			ContestantInputs.namedItem('name').value = name;
			ContestantInputs.namedItem('surname').value = surname;
			ContestantInputs.namedItem('school').value = school;
			ContestantInputs.namedItem('SchoolYear').value = SchoolYear;
		}
		
		NextTransition();
	}
}

function CheckCode(inputs) {
	var email = inputs.namedItem('email').value;
	var code = inputs.namedItem('code').value;
	var OldUser = inputs.namedItem('OldUser').value;
	MakeAjaxRequest('../Modify/ManageVerificationCode.php', {email: email, code: code, OldUser: OldUser, type: 'check'}, CodeConfirmed);
}

function ContestantCreated(response) {
	if (response.type=='good') {
		document.getElementById('ParticipationInfo').elements.namedItem('ContestantId').value = response.data['ContestantId'];
			
		NextTransition();
	}
}

function CreateContestant(inputs) {
	var name = inputs.namedItem('name').value;
	var surname = inputs.namedItem('surname').value;
	var school = inputs.namedItem('school').value;
	var email = inputs.namedItem('email').value;
	var SchoolYear = inputs.namedItem('SchoolYear').value;
	var code = inputs.namedItem('code').value;
	var OldUser = inputs.namedItem('OldUser').value;
	
	MakeAjaxRequest('../Modify/ManageContestantCreation.php', {name: name, surname: surname, school: school, email: email, SchoolYear: SchoolYear, code: code, OldUser: OldUser}, ContestantCreated);
}

function ChangingVolunteer(val) {
	if (val == 'paid') {
		document.getElementById('VolunteerRequestInput').parentNode.parentNode.classList.add('hidden');
	}
	else {
		document.getElementById('VolunteerRequestInput').parentNode.parentNode.classList.remove('hidden');
	}
}

function ParticipationCreated(response) {
	if (response.type=='good') {
		NextTransition();
	}
}

function CreateParticipation(form) {
	var ParticipationData = new FormData(form);
	MakeAjaxRequest('../Modify/ManageParticipationCreation.php', ParticipationData, ParticipationCreated, null, true);
}
