function AddContestant(response) {
	if (response.type == 'good') {
		var surname = response.data['surname'];
		var name = response.data['name'];
		var school = response.data['school'];
		var email = response.data['email'];
		var ContestantId = response.data['ContestantId'];
		
		AddRow(document.getElementById('AdminContestantsTable'), {
			redirect: {'ContestantId': ContestantId},
			values: {'surname': surname, 'name': name, 'school': school, 'email': email} 
		}, 'surname');
	}
}

function AddContestantRequest(inputs) {
	var surname = inputs.namedItem('surname').value;
	var name = inputs.namedItem('name').value;
	var school = inputs.namedItem('school').value;
	var email = inputs.namedItem('email').value;
	MakeAjaxRequest('../Modify/ManageContestant.php', {surname: surname, name: name, school: school, email: email, type: 'add'}, AddContestant);
}
