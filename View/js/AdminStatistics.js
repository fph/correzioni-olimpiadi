

function AddContestToStatistics(){
	//~ Check if the contest exists
	var contest=document.getElementById('ContestInput').value;
	var weight=document.getElementById('WeightInput').value;
	var ContestId=1;
	
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
		
	} 
}

function ViewStatisticsRequest(){
	var tables=document.getElementsByClassName('InformationTable');
	for (var table in tables) {
		if (table.id=='ViewStatisticsTable') table.parentNode.removeChild(table);
	}
	var ContestWeightTable=document.getElementById('AdminContestWeightTable');
	var tbody=ContestWeightTable.getElementsByTagName('tbody')[0];
	var childs=tbody.getElementsByTagName('tr');
	//~ var childs=tbody.childNodes;
	for (var child in childs) console.log(child);

	//~ var data=[];
	//~ for (var child in childs) {
		//~ alert(child);
		//~ var ContestId=GetDataAttribute(child, 'contest_id');
		//~ var WeightTd=child.getElementsByClassName('WeightColumn')[0];
		//~ var weight=parseFloat(WeightTd.innerHTML);
		//~ var nn={'ContestId':ContestId,'weight':weight}
		//~ data.push(nn);
	//~ }
//~ 
	//~ for (var info in data) {
		//~ alert(info);
	//~ }
	//~ MakeAjaxRequest('../Modify/ManageStatistics.php', data, ViewStatistics);
}