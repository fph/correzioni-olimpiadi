function RemoveParticipation(response) {
	if (response.type == 'good') {
		
		row = document.getElementById('trashing'+response.data['ContestantId']); //non è molto pulito
		RemoveRow(document.getElementById('AdminContestantsOfAContestTable'), row);
	}
}

function RemoveParticipationRequest(row) {
	var ContestantId = GetDataAttribute(row, 'contestant_id');
	row.id='trashing'+ContestantId; //non è molto pulito
	MakeAjaxRequest('../Modify/ManageContestant.php', {ContestId: ContestId, ContestantId: ContestantId, type: 'RemoveParticipation'}, RemoveParticipation);
}

function AddParticipation(response) {
	if (response.type == 'good') {
		var surname = response.data['surname'];
		var name = response.data['name'];
		var ContestantId= response.data['ContestantId'];
		
		AddRow(document.getElementById('AdminContestantsOfAContestTable'),
		{	values: {'surname': surname, 'name': name},
			data: {'contestant_id': ContestantId}},
			'surname');
	}
}

function AddParticipationRequest() {
	var ContestantId = GetSelectValue('ContestantInput');
	MakeAjaxRequest('../Modify/ManageContestant.php', {ContestId: ContestId, ContestantId: ContestantId, type: 'AddParticipation'}, AddParticipation);
}
