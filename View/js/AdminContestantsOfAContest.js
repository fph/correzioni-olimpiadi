function RemoveParticipation(response){
	if (response.type=='good') {
		row=document.getElementById('trashing'+response.ContestantId);
		RemoveRow(document.getElementById('AdminContestantsOfAContestTable'), row);
	}
}

function RemoveParticipationRequest(row){
	var ContestantId=GetDataAttribute(row, "contestant_id");
	row.id='trashing'+ContestantId;
	MakeAjaxRequest('../Modify/ManageContestant.php', {ContestId:ContestId, ContestantId:ContestantId, type:'RemoveParticipation'}, RemoveParticipation);
}

function AddParticipation(response){
	if (response.type=='good') {
		var surname=document.getElementById('SurnameInput').value;
		var name=document.getElementById('NameInput').value;
		
		AddRow( document.getElementById('AdminContestantsOfAContestTable'),
		{	values:{'surname':surname,'name':name},
			data:{'contestant_id':response.ContestantId} },
			'surname');
	}
}

function AddParticipationRequest(){ 
	var surname=document.getElementById('SurnameInput').value;
	var name=document.getElementById('NameInput').value;
	MakeAjaxRequest('../Modify/ManageContestant.php', {ContestId:ContestId, surname:surname, name:name, type:'AddParticipation'}, AddParticipation);
}
