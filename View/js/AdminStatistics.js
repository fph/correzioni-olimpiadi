function DeletePreviousStatistics() {
	var tables=document.getElementsByClassName('InformationTable');
	for (var i=0; i<tables.length; i++) {
		if (tables[i].id=='MultipleRankingTable') tables[i].parentNode.removeChild(tables[i]);
	}
}

//This function add the contests to the list of those which will be present in the statistics table
function AddContestToStatistics(){
	var contest=GetSelectText('ContestInput');
	var weight=document.getElementById('WeightInput').value;
	var ContestId=GetSelectValue('ContestInput');
	//Maybe check if the contest is already present?
	
	AddRow( document.getElementById('AdminContestWeightTable'),{
		values:{'contest':contest, 'weight':weight},
		data:{'contest_id':ContestId},
	}, 'contest');
}

function Clear(row){
	var WeightTd=row.getElementsByClassName('WeightColumn')[0];

	WeightTd.innerHTML=GetDataAttribute(WeightTd, "old_value");
	SetDataAttribute(WeightTd, "old_value", null);

	row.getElementsByClassName('ConfirmButtonImage')[0].classList.add('hidden');
	row.getElementsByClassName('CancelButtonImage')[0].classList.add('hidden');

	var ModifyButtons=document.getElementsByClassName('ModifyButtonImage');
	for (i=0; i<ModifyButtons.length; i++) ModifyButtons[i].classList.remove('hidden');

	var TrashButtons=document.getElementsByClassName('TrashButtonImage');
	for (i=0; i<TrashButtons.length; i++) TrashButtons[i].classList.remove('hidden');

	var ViewStatisticsButton=document.getElementById('ViewStatisticsButton');
	ViewStatisticsButton.removeAttribute('disabled','disabled');

	var AddContestButton=document.getElementById('AddContestButton');
	AddContestButton.removeAttribute('disabled','disabled');
}

function Confirm(row){
	var WeightTd=row.getElementsByClassName('WeightColumn')[0];

	var WeightValue=WeightTd.getElementsByClassName('ContentEditable')[0].innerHTML;
	SetDataAttribute(WeightTd, "old_value", WeightValue);

	Clear(row);
}

function OnModification(row){

	var WeightTd=row.getElementsByClassName('WeightColumn')[0];
	var WeightValue=WeightTd.innerHTML;
	SetDataAttribute(WeightTd, "old_value", WeightValue);


	var WeightEditable=document.createElement('div');
	WeightEditable.setAttribute('contenteditable', 'true');
	WeightEditable.classList.add('ContentEditable');
	WeightEditable.innerHTML=WeightValue;
	WeightTd.replaceChild(WeightEditable, WeightTd.childNodes[0]);

	row.getElementsByClassName('ConfirmButtonImage')[0].classList.remove('hidden');
	row.getElementsByClassName('CancelButtonImage')[0].classList.remove('hidden');

	var ModifyButtons=document.getElementsByClassName('ModifyButtonImage');
	for (i=0; i<ModifyButtons.length; i++) ModifyButtons[i].classList.add('hidden');

	var TrashButtons=document.getElementsByClassName('TrashButtonImage');
	for (i=0; i<TrashButtons.length; i++) TrashButtons[i].classList.add('hidden');

	var ViewStatisticsButton=document.getElementById('ViewStatisticsButton');
	ViewStatisticsButton.setAttribute('disabled','disabled');

	var AddContestButton=document.getElementById('AddContestButton');
	AddContestButton.setAttribute('disabled','disabled');
}

function RemoveContest(row){
	RemoveRow(document.getElementById('AdminContestWeightTable'), row);
}

function ViewStatistics(response){
	if (response.type=='good') {
		var MultipleRankingTable=RenderTable(response);
		var ContentContainer=document.getElementById('ContentContainer');
		ContentContainer.appendChild(MultipleRankingTable);
	} 
}

function ViewStatisticsRequest(){
	DeletePreviousStatistics();
	
	var ContestWeightTable=document.getElementById('AdminContestWeightTable');
	var tbody=ContestWeightTable.getElementsByTagName('tbody')[0];
	var childs=tbody.getElementsByTagName('tr');

	var data=[];
	for (var i=0; i<childs.length; i++) {
		child=childs[i];
		var ContestId=GetDataAttribute(child, 'contest_id');
		var WeightTd=child.getElementsByClassName('WeightColumn')[0];
		var weight=parseFloat(WeightTd.innerHTML);
		var nn={'ContestId':ContestId,'weight':weight};
		data.push(nn);
	}

	MakeAjaxRequest('../Modify/ManageStatistics.php', data, ViewStatistics);
}
