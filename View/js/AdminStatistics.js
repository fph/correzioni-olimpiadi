function DeletePreviousStatistics() {
	var tables = document.getElementsByClassName('InformationTable');
	for (var i=0; i<tables.length; i++) {
		if (tables[i].id == 'MultipleRankingTable') tables[i].parentNode.removeChild(tables[i]);
	}
}

//This function add the contests to the list of those which will be present in the statistics table
function AddContestToStatistics(inputs) {
	if (GetSelectStatus('ContestInput') != 1) {
		ShowMessage('bad', 'Si deve selezionare correttamente una gara per aggiungerla alle statistiche');
		return;
	}
	
	var contest = GetSelectText('ContestInput');
	var ContestId = GetSelectValue('ContestInput');
	var weight = inputs.namedItem('weight').value;
	
	if (weight < 0.01) {
		ShowMessage('bad', 'Si deve scegliere un peso positivo');
		return; 
	}
	
	//Maybe check if the contest is already present?
	
	AddRow(document.getElementById('AdminContestWeightTable'), {
		values: {'contest': contest, 'weight': weight},
		data: {'contest_id': ContestId},
	}, 'contest');
}

function RemoveContest(row) {
	RemoveRow(document.getElementById('AdminContestWeightTable'), row);
}

function ViewStatistics(response) {
	if (response.type == 'good') {
		var MultipleRankingTable = RenderTable(response);
		var ContentContainer = document.getElementById('ContentContainer');
		ContentContainer.appendChild(MultipleRankingTable);
	} 
}

function ViewStatisticsRequest() {
	DeletePreviousStatistics();
	
	var ContestWeightTable = document.getElementById('AdminContestWeightTable');
	var tbody = ContestWeightTable.getElementsByTagName('tbody')[0];
	var childs = tbody.getElementsByTagName('tr');

	var data = [];
	for (var i=0; i<childs.length; i++) {
		child = childs[i];
		var ContestId = GetDataAttribute(child, 'contest_id');
		var WeightTd = child.getElementsByClassName('WeightColumn')[0];
		var weight = parseFloat(WeightTd.innerHTML);
		var nn = {'ContestId': ContestId, 'weight': weight};
		data.push(nn);
	}

	MakeAjaxRequest('../Modify/ManageStatistics.php', data, ViewStatistics);
}
