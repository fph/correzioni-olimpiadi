function RemoveContest(){
	setTimeout(function(){Redirect('AdminContests');},2000);
}

function DeleteTitle(){
	MakeAjaxRequest('../Modify/ManageContest.php', {ContestId:ContestId, type:'remove'}, RemoveContest);
}

function ModifyTitle() {
	StartModifyingTitle();
	var NameTitle=document.getElementById('name_title');
	var ItalianDate=document.getElementById('ItalianDate');
	var DateModificationContainer=document.getElementById('DateModificationContainer');
	NameTitle.classList.add('ContentEditable');
	NameTitle.setAttribute('contenteditable','true');
	SetDataAttribute(NameTitle, "old_value", NameTitle.innerHTML);
	ItalianDate.classList.add('hidden');
	DateModificationContainer.classList.remove('hidden');
	SetDate(GetDataAttribute(ItalianDate, "raw_date"));
}

function ProcessServerAnswer( Response ) {
	if ( Response.type == 'bad' ) CancelTitleModification();
	else if (Response.type == 'good' ) {
		var NameTitle=document.getElementById('name_title');
		var path=document.getElementsByClassName('PathElement');
		path[path.length-1].innerHTML = NameTitle.innerHTML;
		var ItalianDate=document.getElementById('ItalianDate');
		var RawDate=document.getElementById('date_DateInput');
		SetDataAttribute(ItalianDate, "raw_date", RawDate.value);
	}
}

function SendTitleModification(){
	EndModifyingTitle();
	var NameTitle=document.getElementById('name_title');
	NameTitle.classList.remove('ContentEditable');
	NameTitle.setAttribute('contenteditable','false');
	
	var ItalianDate=document.getElementById('ItalianDate');
	var RawDate=document.getElementById('date_DateInput');
	var DateModificationContainer=document.getElementById('DateModificationContainer');
	ItalianDate.innerHTML= '- '+GenerateItalianDate(RawDate.value);
	ItalianDate.classList.remove('hidden');
	DateModificationContainer.classList.add('hidden');
	
	MakeAjaxRequest('../Modify/ManageContest.php', 
	{ContestId: ContestId, name:NameTitle.innerHTML, date:RawDate.value, type:'ChangeNameAndDate'} , 
	ProcessServerAnswer);
}

function CancelTitleModification(){
	EndModifyingTitle();
	var NameTitle=document.getElementById('name_title');	
	NameTitle.classList.remove('ContentEditable');
	NameTitle.setAttribute('contenteditable','false');
	NameTitle.innerHTML=GetDataAttribute(NameTitle, "old_value");
	SetDataAttribute(NameTitle, "old_value", null);
	
	var ItalianDate=document.getElementById('ItalianDate');
	var DateModificationContainer=document.getElementById('DateModificationContainer');
	ItalianDate.innerHTML= '- '+GenerateItalianDate(GetDataAttribute(ItalianDate, "raw_date"));
	ItalianDate.classList.remove('hidden');
	DateModificationContainer.classList.add('hidden');
}

function ClearCorrectionsState(){
	var CorrectionsInformationContainer=document.getElementById('CorrectionsInformationContainer');
	var CorrectionsState=CorrectionsInformationContainer.getElementsByClassName('CorrectionsState')[0];

	if (GetDataAttribute(CorrectionsState, 'old_value')=='unblock') {
		CorrectionsState.innerHTML='Correzioni in corso';
		CorrectionsState.classList.add('CorrectionsInProgress');
	}
	else {
		CorrectionsState.innerHTML='Correzioni terminate';
		CorrectionsState.classList.add('CorrectionsCompleted');
	}

	SetDataAttribute(CorrectionsState, 'old_value', null);

	var modify_button=CorrectionsInformationContainer.getElementsByClassName('ModifyButtonContainer')[0];
	var confirm_button=CorrectionsInformationContainer.getElementsByClassName('ConfirmButtonContainer')[0];
	var cancel_button=CorrectionsInformationContainer.getElementsByClassName('CancelButtonContainer')[0];

	modify_button.classList.remove('hidden');
	confirm_button.classList.add('hidden');
	cancel_button.classList.add('hidden');
}

function MakeChangesCorrectionsState(response){
	var CorrectionsInformationContainer=document.getElementById('CorrectionsInformationContainer');
	var CorrectionsState=CorrectionsInformationContainer.getElementsByClassName('CorrectionsState')[0];
	if (response.type=='good') {
		SetDataAttribute(CorrectionsState, 'old_value', GetDataAttribute(CorrectionsState, 'new_value'));
	}
	SetDataAttribute(CorrectionsState, 'new_value', null);
	ClearCorrectionsState();
}

function ConfirmCorrectionsState(){
	var CorrectionsInformationContainer=document.getElementById('CorrectionsInformationContainer');
	var CorrectionsState=CorrectionsInformationContainer.getElementsByClassName('CorrectionsState')[0];

	var selectEl=CorrectionsState.getElementsByClassName('corrections_state_select')[0];
	var NewCorrectionsState=selectEl.options[selectEl.selectedIndex].value;

	SetDataAttribute(CorrectionsState, 'new_value', NewCorrectionsState);

	MakeAjaxRequest('../Modify/ManageContest.php', {ContestId: ContestId, type:NewCorrectionsState}, MakeChangesCorrectionsState);
}


function OnModificationCorrectionsState(){
	var CorrectionsInformationContainer=document.getElementById('CorrectionsInformationContainer');
	var CorrectionsState=CorrectionsInformationContainer.getElementsByClassName('CorrectionsState')[0];
	var NewStateHTML="<select class='corrections_state_select'>";
	if (CorrectionsState.classList.contains('CorrectionsInProgress')) {
		NewStateHTML+="<option value='unblock' selected='selected'> Correzioni in corso";
		NewStateHTML+="<option value='block'> Correzioni terminate";
		CorrectionsState.classList.remove('CorrectionsInProgress');
		SetDataAttribute(CorrectionsState, 'old_value', 'unblock');
	}
	else {
		NewStateHTML+="<option value='unblock'> Correzioni in corso";
		NewStateHTML+="<option value='block' selected='selected'> Correzioni terminate";
		CorrectionsState.classList.remove('CorrectionsCompleted');
		SetDataAttribute(CorrectionsState, 'old-value', 'block');
	}
	NewStateHTML+="</select>";

	CorrectionsState.innerHTML=NewStateHTML;

	var modify_button=CorrectionsInformationContainer.getElementsByClassName('ModifyButtonContainer')[0];
	var confirm_button=CorrectionsInformationContainer.getElementsByClassName('ConfirmButtonContainer')[0];
	var cancel_button=CorrectionsInformationContainer.getElementsByClassName('CancelButtonContainer')[0];

	modify_button.classList.add('hidden');
	confirm_button.classList.remove('hidden');
	cancel_button.classList.remove('hidden');
	//~ MakeAjaxRequest('../Modify/ManageContest.php', {ContestId: ContestId, type:unblock}, UnblockContest);
}
