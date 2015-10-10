function SetOldUser(val) {
	document.getElementById('SendCodeForm').elements.namedItem('OldUser').value = val;
	document.getElementById('CheckCodeForm').elements.namedItem('OldUser').value = val;
}

function CodeSent(response) {
	if (response.type == 'good') {
		var email = response.data['email'];
		document.getElementById('CheckCodeForm').elements.namedItem('email').value = email;
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
		ContestantInputs.namedItem('email').value = email;
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
			document.getElementById('ParticipationInfo').elements.namedItem('ContestantId').value = ContestantId;
		}
	}
}

function CheckCode(inputs) {
	var email = inputs.namedItem('email').value;
	var code = inputs.namedItem('code').value;
	var OldUser = inputs.namedItem('OldUser').value;
	MakeAjaxRequest('../Modify/ManageVerificationCode.php', {email: email, code: code, OldUser: OldUser, type: 'check'}, CodeConfirmed);
}

function CreateContestant(inputs) {
	var name = inputs.namedItem('name').value;
	var surname = inputs.namedItem('surname').value;
	var school = inputs.namedItem('school').value;
	var email = inputs.namedItem('email').value;
	var SchoolYear = inputs.namedItem('SchoolYear').value;
	var code = inputs.namedItem('code').value;
	MakeAjaxRequest('../Modify/ManageContestantCreation.php', {name: name, surname: surname, school: school, email: email, SchoolYear: SchoolYear, code: code});
}


function CreateParticipation(form) {
	// var ContestantId = inputs.namedItem('ContestantId').value;
	// var ContestId = inputs.namedItem('ContestId').value;
	// var StagesNumber = inputs.namedItem('StagesNumber').value;
	// var code = inputs.namedItem('code').value;
	
	// var solutions = inputs.namedItem('solutions').files[0];
	// formData.append('solutions', solutions, solutions.name);
	
	// var xxx = new FormData(form);
	var ParticipationData = new FormData(form);
	MakeAjaxRequest('../Modify/ManageParticipationCreation.php', ParticipationData, null, null, true);
}
