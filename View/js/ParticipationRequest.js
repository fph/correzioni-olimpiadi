function SetOldUser(val) {
	document.getElementById('SendCodeForm').elements.namedItem('OldUser').value = val;
	document.getElementById('CheckCodeForm').elements.namedItem('OldUser').value = val;
	document.getElementById('ContestantInfo').elements.namedItem('OldUser').value = val;
}

function CodeSent(response) {
	if (response.type == 'good') {
		var email = response.data['email'];
		document.getElementById('CheckCodeForm').elements.namedItem('email').value = email;
		document.getElementById('ContestantInfo').elements.namedItem('email').value = email;
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
		
		document.getElementById('ContestantInfoDiv').classList.remove('BeforeForm');
		document.getElementById('ContestantInfoDiv').classList.add('ShowingForm');
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
	}
	// DEBUG
	document.getElementById('ContestantInfoDiv').classList.remove('ShowingForm');
	document.getElementById('ContestantInfoDiv').classList.add('AfterForm');
	
	document.getElementById('ParticipationInfoDiv').classList.remove('BeforeForm');
	document.getElementById('ParticipationInfoDiv').classList.add('ShowingForm');
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

function CreateParticipation(form) {
	var ParticipationData = new FormData(form);
	MakeAjaxRequest('../Modify/ManageParticipationCreation.php', ParticipationData, null, null, true);
}
