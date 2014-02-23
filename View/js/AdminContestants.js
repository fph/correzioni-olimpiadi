function AddContestant(response){
	if (response.type=='good') {
		var surname=document.getElementById('surname_input').value;
		var name=document.getElementById('name_input').value;
		
		AddRow({surname:surname, name:name},{0:'trlink'},'AdminContestantInformation', {'ContestantId':response.ContestantId}, 'surname');
	}
}

function AddContestantRequest() {
	var surname=document.getElementById('surname_input').value;
	var name=document.getElementById('name_input').value;
	var school=document.getElementById('school_input').value;
	MakeAjaxRequest('../Modify/ManageContestant.php', {surname:surname, name:name, school:school, type:'add'}, AddContestant);
}
