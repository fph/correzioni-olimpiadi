function RemoveParticipation(response) {
	if (response.type == 'good') {
		
		row = document.getElementById('trashing'+response.data['ContestantId']); //non è molto pulito
		RemoveRow(document.getElementById('AdminContestantsOfAContestTable'), row);
	}
}

function RemoveParticipationRequest(row) {
	var ContestantId = GetDataAttribute(row, 'contestant_id');
	row.id = 'trashing' + ContestantId; //non è molto pulito
	MakeAjaxRequest('../Modify/ManageContestant.php', {ContestId: ContestId, ContestantId: ContestantId, type: 'RemoveParticipation'}, RemoveParticipation);
}

function AddParticipation(response) {
	if (response.type == 'good') {
		var surname = response.data['surname'];
		var name = response.data['name'];
		var ContestantId = response.data['ContestantId'];
		var SolutionsBoolean = response.data['SolutionsBoolean'];
		
		var solutions = '';
		if (SolutionsBoolean) {
			solutions = '<a href=\'../Modify/DownloadFiles.php?type=ParticipationPdf&ContestId=' + ContestId + '&ContestantId=' + ContestantId + '\' download class=\'DownloadIconTable\'><img src=\'../View/Images/DownloadPdf.png\' alt=\'Scarica elaborato\' title=\'Scarica elaborato\'></a>';
		}
		
		// TODO: Qui si dovrebbe piazzare anche il link per il download
		AddRow(document.getElementById('AdminContestantsOfAContestTable'), {
			values: {
				'surname': surname, 
				'name': name,
				'solutions': solutions
			},
			data: {'contestant_id': ContestantId}
		}, 'surname');
	}
}

function AddParticipationRequest(inputs) {
	// It is mandatory to use formdata as it is the only way to send a file through ajax
	// Anyway it sends everything in the usual 'data' way apart from the pdf file.
	var ParticipationData = new FormData();
	ParticipationData.append('solutions', inputs.namedItem('solutions').files[0]);
	var ContestantId = inputs.namedItem('ContestantId').value;
	ParticipationData.append('data', JSON.stringify({ContestId: ContestId, ContestantId: ContestantId, type: 'AddParticipation'}));
	
	MakeAjaxRequest('../Modify/ManageContestant.php', ParticipationData, AddParticipation, null, true);
}
