function RemoveProblem(response){
	if (response.type=='good') {
		row=document.getElementById('trashing'+response.ProblemId);
		RemoveRow(document.getElementById('AdminProblemsOfAContestTable'), row);
	}
}

function RemoveProblemRequest(row) {
	var ProblemId=GetDataAttribute(row, 'problem_id');
	row.id='trashing'+ProblemId;
	MakeAjaxRequest('../Modify/ManageContest.php', {ProblemId:ProblemId, type:'RemoveProblem'}, RemoveProblem);
}

function AddProblem(response){
	if (response.type=='good') {
		var problem=document.getElementById('ProblemInput').value;
		AddRow( document.getElementById('AdminProblemsOfAContestTable'),
		{	values:{'problem':problem},
			data:{'problem_id':response.ProblemId } },
		'problem');
	}
}

function AddProblemRequest() {
	var problem=document.getElementById('ProblemInput').value;
	MakeAjaxRequest('../Modify/ManageContest.php', {ContestId:ContestId, name:problem, type:'AddProblem'}, AddProblem);
}

function Clear(row){
	row.removeAttribute('id');

	var ProblemTd=row.getElementsByClassName('ProblemColumn')[0];
	ProblemTd.innerHTML=GetDataAttribute(ProblemTd, 'old_value');
	SetDataAttribute(ProblemTd, 'old_value', null);

	var ModifyButtons=document.getElementsByClassName('ModifyButtonContainer');
	for (i=0; i<ModifyButtons.length; i++) ModifyButtons[i].classList.remove('hidden');

	var TrashButtons=document.getElementsByClassName('TrashButtonContainer');
	for (i=0; i<TrashButtons.length; i++) TrashButtons[i].classList.remove('hidden');

	var InputButton=document.getElementById('InputButton');
	InputButton.removeAttribute('disabled','disabled');
}

function MakeChanges(response){
	var row=document.getElementById('modifying');
	var ProblemTd=row.getElementsByClassName('ProblemColumn')[0];
	if (response.type=='good') {
		SetDataAttribute(ProblemTd, 'old_value', GetDataAttribute(ProblemTd, 'new_value'));
	}
	SetDataAttribute(ProblemTd, 'new_value', null);
	Clear(row);
}

function Confirm(row) {	
	var ProblemTd=row.getElementsByClassName('ProblemColumn')[0];
	
	var ProblemName=ProblemTd.getElementsByClassName('ContentEditable')[0].innerHTML;
	SetDataAttribute(ProblemTd, 'new_value', ProblemName);

	var ProblemId=GetDataAttribute(row, 'problem_id');
	
	MakeAjaxRequest('../Modify/ManageContest.php', {type:'ChangeProblemName', name:ProblemName, ProblemId:ProblemId}, MakeChanges);
}


function OnModification(row){
	row.id='modifying';

	var ProblemTd=row.getElementsByClassName('ProblemColumn')[0];
	var ProblemValue=ProblemTd.innerHTML;
	SetDataAttribute(ProblemTd, 'old_value', ProblemValue);


	var ProblemEditable=document.createElement('div');
	ProblemEditable.setAttribute('contenteditable', 'true');
	ProblemEditable.classList.add('ContentEditable');
	ProblemEditable.innerHTML=ProblemValue;
	ProblemTd.replaceChild(ProblemEditable, ProblemTd.childNodes[0]);

	var ModifyButtons=document.getElementsByClassName('ModifyButtonContainer');
	for (i=0; i<ModifyButtons.length; i++) ModifyButtons[i].classList.add('hidden');

	var TrashButtons=document.getElementsByClassName('TrashButtonContainer');
	for (i=0; i<TrashButtons.length; i++) TrashButtons[i].classList.add('hidden');

	var InputButton=document.getElementById('InputButton');
	InputButton.setAttribute('disabled','disabled');
}
