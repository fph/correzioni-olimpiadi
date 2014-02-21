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

function BlockContest() {

}

function BlockContestRequest(){
	MakeAjaxRequest('../Modify/ManageContest.php', {ContestId: ContestId, type:block}, BlockContest);
}

function UnblockContest() {

}

function UnblockContestRequest(){
	MakeAjaxRequest('../Modify/ManageContest.php', {ContestId: ContestId, type:unblock}, UnblockContest);
}
