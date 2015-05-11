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

function AddContestantRequest() {
	var surname = document.getElementById('SurnameInput').value;
	var name = document.getElementById('NameInput').value;
	var school = document.getElementById('SchoolInput').value;
	var email = document.getElementById('EmailInput').value;
	MakeAjaxRequest('../Modify/ManageContestant.php', {surname: surname, name: name, school: school, email: email, type: 'add'}, AddContestant);
}
