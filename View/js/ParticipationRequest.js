function CodeSent(response) {
	if (response.type == 'good') {
		var email = response.data['email'];
		document.getElementById('CheckCodeForm').elements.namedItem('email').value = email;
	}
}

function SendCode(inputs) {
	var email = inputs.namedItem('email').value;
	MakeAjaxRequest('../Modify/ManageVerificationCode.php', {email: email, type: 'send'}, CodeSent);
}

function CodeConfirmed(response) {
	if (response.type == 'good') {
		var email = response.data['email'];
		var code = response.data['code'];
		document.getElementById('ContestantInfo').elements.namedItem('email').value = email;
		document.getElementById('ContestantInfo').elements.namedItem('code').value = code;
	}
}

function CheckCode(inputs) {
	var email = inputs.namedItem('email').value;
	var code = inputs.namedItem('code').value;
	MakeAjaxRequest('../Modify/ManageVerificationCode.php', {email: email, code: code, type: 'check'}, CodeConfirmed);
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
