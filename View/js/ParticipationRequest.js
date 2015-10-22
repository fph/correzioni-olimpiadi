function AdvanceTransition(id1, id2) {
	if (id1 != null) {
		document.getElementById(id1).classList.remove('DuringTransition');
		document.getElementById(id1).classList.add('AfterTransition');
	}
	
	if (id2 != null) {
		document.getElementById(id2).classList.remove('BeforeTransition');
		document.getElementById(id2).classList.add('DuringTransition');
	}
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
	
	AdvanceTransition(null, 'SendCodeDiv');
}

function CodeSent(response) {
	if (response.type == 'good') {
		var email = response.data['email'];
		document.getElementById('CheckCodeForm').elements.namedItem('email').value = email;
		document.getElementById('ContestantInfo').elements.namedItem('email').value = email;
		
		AdvanceTransition('SendCodeDiv', 'CheckCodeDiv');
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
		
		AdvanceTransition('SendCodeDiv', 'ContestantInfoDiv');
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
			
		AdvanceTransition('ContestantInfoDiv', 'ParticipationInfoDiv');
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
		AdvanceTransition('ParticipationInfoDiv', 'RegistrationEndDiv');
	}
}

function CreateParticipation(form) {
	var ParticipationData = new FormData(form);
	MakeAjaxRequest('../Modify/ManageParticipationCreation.php', ParticipationData, ParticipationCreated, null, true);
}
