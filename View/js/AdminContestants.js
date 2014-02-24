function AddContestant(response){
	if (response.type=='good') {
		var surname=document.getElementById('SurnameInput').value;
		var name=document.getElementById('NameInput').value;
		var school=document.getElementById('SchoolInput').value;
		
		AddRow({surname:surname, name:name, school:school},{0:'trlink'},'AdminContestantInformation', {'ContestantId':response.ContestantId}, 'surname');
	}
}

function AddContestantRequest() {
	var surname=document.getElementById('SurnameInput').value;
	var name=document.getElementById('NameInput').value;
	var school=document.getElementById('SchoolInput').value;
	MakeAjaxRequest('../Modify/ManageContestant.php', {surname:surname, name:name, school:school, type:'add'}, AddContestant);
}
