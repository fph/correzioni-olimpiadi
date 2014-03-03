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

function AddParticipation(response){ // qui diventa tutto buggato!
	if (response.type=='good') {
		//~ var surname=document.getElementById('SurnameInput').value;
		//~ var name=document.getElementById('NameInput').value;
		var surname='Cognomme';
		var name='Nomme';
		
		AddRow( document.getElementById('AdminContestantsOfAContestTable'),
		{	values:{'surname':surname,'name':name},
			data:{'contestant_id':response.ContestantId} },
			'surname');
	}
}

function AddParticipationRequest(){ 
	var ContestantId=GetSelectValue('ContestantInput');
	MakeAjaxRequest('../Modify/ManageContestant.php', {ContestId:ContestId, ContestantId:ContestantId, type:'AddParticipation'}, AddParticipation);
}
