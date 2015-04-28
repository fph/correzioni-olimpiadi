function RemoveContest(){
	setTimeout(function(){Redirect('AdminContests');},2000);
}

function DeleteTitle(){
	MakeAjaxRequest('../Modify/ManageContest.php', {ContestId:ContestId, type:'remove'}, RemoveContest);
}

function ModifyTitle() {
	var NameTitle=document.getElementById('name_title');
	var ItalianDate=document.getElementById('ItalianDate');
	var DateModificationContainer=document.getElementById('DateModificationContainer');
	NameTitle.classList.add('ContentEditable');
	NameTitle.setAttribute('contenteditable','true');
	SetDataAttribute(NameTitle, 'old_value', NameTitle.innerHTML);
	ItalianDate.classList.add('hidden');
	DateModificationContainer.classList.remove('hidden');
	SetDate( GetDataAttribute(ItalianDate, 'raw_date') , document.getElementById('TitleDateModification'));
}

function ProcessServerAnswer( Response ) {
	if ( Response.type == 'bad' ) CancelTitleModification();
	else if (Response.type == 'good' ) {
		var NameTitle=document.getElementById('name_title');
		var path=document.getElementsByClassName('PathElement');
		path[path.length-1].innerHTML = NameTitle.innerHTML;
		var ItalianDate=document.getElementById('ItalianDate');
		var RawDate=GetDateValue('TitleDateModification');
		SetDataAttribute(ItalianDate, 'raw_date', RawDate);
	}
}

function SendTitleModification(){
	var NameTitle=document.getElementById('name_title');
	NameTitle.classList.remove('ContentEditable');
	NameTitle.setAttribute('contenteditable','false');
	
	var ItalianDate=document.getElementById('ItalianDate');
	var RawDate=GetDateValue('TitleDateModification');
	var DateModificationContainer=document.getElementById('DateModificationContainer');
	ItalianDate.innerHTML= '- '+GetItalianDate(RawDate);
	ItalianDate.classList.remove('hidden');
	DateModificationContainer.classList.add('hidden');
	
	MakeAjaxRequest('../Modify/ManageContest.php', 
	{ContestId: ContestId, name:NameTitle.innerHTML, date:RawDate, type:'ChangeNameAndDate'} , 
	ProcessServerAnswer);
}

function CancelTitleModification(){
	var NameTitle=document.getElementById('name_title');	
	NameTitle.classList.remove('ContentEditable');
	NameTitle.setAttribute('contenteditable','false');
	NameTitle.innerHTML=GetDataAttribute(NameTitle, 'old_value');
	SetDataAttribute(NameTitle, 'old_value', null);
	
	var ItalianDate=document.getElementById('ItalianDate');
	var DateModificationContainer=document.getElementById('DateModificationContainer');
	ItalianDate.innerHTML= '- '+GetItalianDate(GetDataAttribute(ItalianDate, 'raw_date'));
	ItalianDate.classList.remove('hidden');
	DateModificationContainer.classList.add('hidden');
}

function CancelCorrectionsState(){
	var container=document.getElementById('CorrectionsInformationContainer');
	var span=document.getElementById('CorrectionsStateSpan');
	var select=document.getElementById('CorrectionsStateSelect');
	
	span.classList.remove('hidden');
	select.classList.add('hidden');
	
	SetDataAttribute(container, 'old_value', null);
}

function MakeChangesCorrectionsState(response){
	var container=document.getElementById('CorrectionsInformationContainer');
	var span=document.getElementById('CorrectionsStateSpan');
	var select=document.getElementById('CorrectionsStateSelect');
	
	if (response.type=='good') {
		var value=GetDataAttribute(container, 'new_value');
		SetDataAttribute(container, 'value', value);
		SetDataAttribute(container, 'new_value', null);
		SetDataAttribute(container, 'old_value', null);
		select.classList.add('hidden');
		
		span.classList.remove('CorrectionsInProgress');
		span.classList.remove('CorrectionsCompleted');
		span.classList.add((value=='block')?'CorrectionsCompleted':'CorrectionsInProgress');
		span.textContent=(value=='block')?'Correzioni terminate':'Correzioni in corso';
		span.classList.remove('hidden');
	}
	else {
		CancelCorrectionsState();
	}
}

function ConfirmCorrectionsState(){
	var container=document.getElementById('CorrectionsInformationContainer');
	var span=document.getElementById('CorrectionsStateSpan');
	var select=document.getElementById('CorrectionsStateSelect');
	
	var NewValue=select.options[select.selectedIndex].value;
	SetDataAttribute(container, 'new_value', NewValue);
	MakeAjaxRequest('../Modify/ManageContest.php', {ContestId: ContestId, type:NewValue}, MakeChangesCorrectionsState);
}

function ModifyCorrectionsState(){
	var container=document.getElementById('CorrectionsInformationContainer');
	var span=document.getElementById('CorrectionsStateSpan');
	var select=document.getElementById('CorrectionsStateSelect');
	span.classList.add('hidden');
	
	select.selectedIndex=(GetDataAttribute(container, 'value')=='block')?0:1;
	select.classList.remove('hidden');
}
