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
	SetDataAttribute(surname, 'old_value', surname.innerHTML);
	SetDataAttribute(name, 'old_value', name.innerHTML);
}

function ProcessServerAnswer( response ) {
	if ( response.type == 'bad' ) CancelTitleModification();
	else if (response.type == 'good' ) {
		var surname=response.data['surname'];
		var name=response.data['name'];		
		var path=document.getElementsByClassName('PathElement');
		path[path.length-1].innerHTML = surname +' '+ name;
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
	surname.innerHTML=GetDataAttribute(surname, 'old_value');
	name.innerHTML=GetDataAttribute(name, 'old_value');
	SetDataAttribute(surname, 'old_value', null);
	SetDataAttribute(name, 'old_value', null);
}

//~ School
function EndSchoolModification() {
	var subtitle=document.getElementsByClassName('PageSubtitle')[0];

	var modify_button=subtitle.getElementsByClassName('ModifyButtonContainer')[0];
	var confirm_button=subtitle.getElementsByClassName('ConfirmButtonContainer')[0];
	var cancel_button=subtitle.getElementsByClassName('CancelButtonContainer')[0];

	modify_button.classList.remove('hidden');
	confirm_button.classList.add('hidden');
	cancel_button.classList.add('hidden');
	
	var SchoolSpan=document.getElementById('ContestantSchool');
	SchoolSpan.classList.remove('ContentEditable');
	SchoolSpan.setAttribute('contenteditable','false');
}

function CancelSchool(){
	EndSchoolModification();
	var SchoolSpan=document.getElementById('ContestantSchool');
	SchoolSpan.innerHTML=GetDataAttribute(SchoolSpan, 'old_value');
	SetDataAttribute(SchoolSpan, 'old_value', null);
}

function MakeChangesSchool(response){
	if( response.type=='bad' ) {
		CancelSchool();
	}
}

function ConfirmSchool(){
	EndSchoolModification();
	var SchoolSpan=document.getElementById('ContestantSchool');
	MakeAjaxRequest('../Modify/ManageContestant.php', {ContestantId: ContestantId, school: SchoolSpan.innerHTML, type:'ChangeSchool'}, MakeChangesSchool);
}


function ModifySchool(){
	var SchoolSpan=document.getElementById('ContestantSchool');
	SetDataAttribute(SchoolSpan, 'old_value', SchoolSpan.innerHTML);
	SchoolSpan.classList.add('ContentEditable');
	SchoolSpan.setAttribute('contenteditable','true');
	
	var subtitle=document.getElementsByClassName('PageSubtitle')[0];

	var modify_button=subtitle.getElementsByClassName('ModifyButtonContainer')[0];
	var confirm_button=subtitle.getElementsByClassName('ConfirmButtonContainer')[0];
	var cancel_button=subtitle.getElementsByClassName('CancelButtonContainer')[0];

	modify_button.classList.add('hidden');
	confirm_button.classList.remove('hidden');
	cancel_button.classList.remove('hidden');
}

//~ Email
function EndEmailModification() {
	var subtitle=document.getElementsByClassName('PageSubtitle')[1];

	var modify_button=subtitle.getElementsByClassName('ModifyButtonContainer')[0];
	var confirm_button=subtitle.getElementsByClassName('ConfirmButtonContainer')[0];
	var cancel_button=subtitle.getElementsByClassName('CancelButtonContainer')[0];

	modify_button.classList.remove('hidden');
	confirm_button.classList.add('hidden');
	cancel_button.classList.add('hidden');
	
	var EmailSpan=document.getElementById('ContestantEmail');
	EmailSpan.classList.remove('ContentEditable');
	EmailSpan.setAttribute('contenteditable','false');
}

function CancelEmail(){
	EndEmailModification();
	var EmailSpan=document.getElementById('ContestantEmail');
	EmailSpan.innerHTML=GetDataAttribute(EmailSpan, 'old_value');
	SetDataAttribute(EmailSpan, 'old_value', null);
}

function MakeChangesEmail(response){
	if( response.type=='bad' ) {
		CancelEmail();
	}
}

function ConfirmEmail(){
	EndEmailModification();
	var EmailSpan=document.getElementById('ContestantEmail');
	MakeAjaxRequest('../Modify/ManageContestant.php', {ContestantId: ContestantId, email: EmailSpan.innerHTML, type:'ChangeEmail'}, MakeChangesEmail);
}


function ModifyEmail(){
	var EmailSpan=document.getElementById('ContestantEmail');
	SetDataAttribute(EmailSpan, 'old_value', EmailSpan.innerHTML);
	EmailSpan.classList.add('ContentEditable');
	EmailSpan.setAttribute('contenteditable','true');
	
	var subtitle=document.getElementsByClassName('PageSubtitle')[1];

	var modify_button=subtitle.getElementsByClassName('ModifyButtonContainer')[0];
	var confirm_button=subtitle.getElementsByClassName('ConfirmButtonContainer')[0];
	var cancel_button=subtitle.getElementsByClassName('CancelButtonContainer')[0];

	modify_button.classList.add('hidden');
	confirm_button.classList.remove('hidden');
	cancel_button.classList.remove('hidden');
}
