function AddContestant(response){
	if (response.type=='good') {
		var surname=response.data['surname'];
		var name=response.data['name'];
		var school=response.data['school'];
		var ContestantId=response.data['ContestantId'];
		
		AddRow( document.getElementById('AdminContestantsTable'),{
			redirect:{'ContestantId':ContestantId},
			values:{'surname':surname,'name':name,'school':school} 
		},'surname');
	}
}

function AddContestantRequest() {
	var surname=document.getElementById('SurnameInput').value;
	var name=document.getElementById('NameInput').value;
	var school=document.getElementById('SchoolInput').value;
	MakeAjaxRequest('../Modify/ManageContestant.php', {surname:surname, name:name, school:school, type:'add'}, AddContestant);
}
