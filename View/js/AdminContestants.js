function AddContestant(response) {
	if (response.type == 'good') {
		var surname = response.data['surname'];
		var name = response.data['name'];
		var school = response.data['school'];
		var SchoolCity = response.data['SchoolCity'];
		var email = response.data['email'];
		var LastOlympicYear = response.data['LastOlympicYear'];
		var ContestantId = response.data['ContestantId'];
		
		AddRow(document.getElementById('AdminContestantsTable'), {
			redirect: {'ContestantId': ContestantId},
			values: {'surname': surname, 'name': name, 'school': school, 'SchoolCity': SchoolCity, 'email': email, 'LastOlympicYear': LastOlympicYear} 
		}, 'surname');
	}
}

function AddContestantRequest(inputs) {
	var surname = inputs.namedItem('surname').value;
	var name = inputs.namedItem('name').value;
	var school = inputs.namedItem('school').value;
	var SchoolCity = inputs.namedItem('SchoolCity').value;
	var email = inputs.namedItem('email').value;
	var LastOlympicYear = inputs.namedItem('LastOlympicYear').value;
	MakeAjaxRequest('../Modify/ManageContestant.php', {surname: surname, name: name, school: school, SchoolCity: SchoolCity, email: email, LastOlympicYear: LastOlympicYear, type: 'add'}, AddContestant);
}
