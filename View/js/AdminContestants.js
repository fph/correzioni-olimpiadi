function AddContestant(response){
	if (response.type=='good') { //TODO
		var surname=document.getElementById('SurnameInput').value;
		var name=document.getElementById('NameInput').value;
		var school=document.getElementById('SchoolInput').value;
		
		AddRow( document.getElementById('AdminContestantsTable'),
		{	redirect:{'ContestantId':response.ContestantId},
			values:{'surname':surname,'name':name,'school':school} },
			'surname');
	}
}

function AddContestantRequest() {
	var surname=document.getElementById('SurnameInput').value;
	var name=document.getElementById('NameInput').value;
	var school=document.getElementById('SchoolInput').value;
	MakeAjaxRequest('../Modify/ManageContestant.php', {surname:surname, name:name, school:school, type:'add'}, AddContestant);
}
