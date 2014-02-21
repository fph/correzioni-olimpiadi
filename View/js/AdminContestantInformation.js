function RemoveContestant(){
	setTimeout(function(){Redirect('AdminContestants');},2000);
}

function DeleteTitle(){
	MakeAjaxRequest('../Modify/ManageContestant.php', {ContestantId:ContestantId, type:'remove'}, RemoveContestant);
}

function ModifyTitle() {
	StartModifyingTitle();
	var surname=document.getElementById('ContestantSurname');
	var name=document.getElementById('ContestantName');
	surname.classList.add('ContentEditable');
	name.classList.add('ContentEditable');
	surname.setAttribute('contenteditable','true');
	name.setAttribute('contenteditable','true');
	SetDataAttribute(surname, "old_value", surname.innerHTML);
	SetDataAttribute(name, "old_value", name.innerHTML);
}

function ProcessServerAnswer( Response ) {
	if ( Response.type == 'bad' ) CancelTitleModification();
	else if (Response.type == 'good' ) {
		var surname=document.getElementById('ContestantSurname');
		var name=document.getElementById('ContestantName');		
		var path=document.getElementsByClassName('PathElement');
		path[path.length-1].innerHTML = surname.innerHTML +' '+ name.innerHTML;
	}
}

function SendTitleModification(){
	EndModifyingTitle();
	
	var surname=document.getElementById('ContestantSurname');
	var name=document.getElementById('ContestantName');
	surname.classList.remove('ContentEditable');
	name.classList.remove('ContentEditable');
	surname.setAttribute('contenteditable','false');
	name.setAttribute('contenteditable','false');
	MakeAjaxRequest('../Modify/ManageContestant.php', 
	{ContestantId: ContestantId, name:name.innerHTML, surname: surname.innerHTML, type:'ChangeNameAndSurname'} , 
	ProcessServerAnswer);
}

function CancelTitleModification(){
	EndModifyingTitle();
	var surname=document.getElementById('ContestantSurname');
	var name=document.getElementById('ContestantName');
	surname.classList.remove('ContentEditable');
	name.classList.remove('ContentEditable');
	surname.setAttribute('contenteditable','false');
	name.setAttribute('contenteditable','false');
	surname.innerHTML=GetDataAttribute(surname, "old_value");
	name.innerHTML=GetDataAttribute(name, "old_value");
	SetDataAttribute(surname, "old_value", null);
	SetDataAttribute(name, "old_value", null);
}
