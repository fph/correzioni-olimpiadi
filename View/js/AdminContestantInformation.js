function RemoveContestant(){
	setTimeout(function(){Redirect('AdminContestants');},2000);
}

function RemoveContestantRequest(ContestantId){
	MakeAjaxRequest('../Modify/ManageContestant.php', {ContestantId:ContestantId, type:'remove'}, RemoveContestant);
}

function StartModifying() {
	var buttonsTitle=document.getElementsByClassName('buttons_title')[0];
	buttonsTitle.getElementsByClassName('modify_button_container')[0].classList.add('HiddenButtonContainer');
	buttonsTitle.getElementsByClassName('trash_button_container')[0].classList.add('HiddenButtonContainer');
	buttonsTitle.getElementsByClassName('confirm_button_container')[0].classList.remove('HiddenButtonContainer');
	buttonsTitle.getElementsByClassName('cancel_button_container')[0].classList.remove('HiddenButtonContainer');
	var surname=document.getElementById('ContestantSurname');
	var name=document.getElementById('ContestantName');
	surname.classList.add('ContentEditable');
	name.classList.add('ContentEditable');
	surname.setAttribute('contenteditable','true');
	name.setAttribute('contenteditable','true');
}

function EndModifying() {
	var ButtonsTitle=document.getElementsByClassName('buttons_title')[0];
	ButtonsTitle.getElementsByClassName('modify_button_container')[0].classList.remove('HiddenButtonContainer');
	ButtonsTitle.getElementsByClassName('trash_button_container')[0].classList.remove('HiddenButtonContainer');
	ButtonsTitle.getElementsByClassName('confirm_button_container')[0].classList.add('HiddenButtonContainer');
	ButtonsTitle.getElementsByClassName('cancel_button_container')[0].classList.add('HiddenButtonContainer');
	var surname=document.getElementById('ContestantSurname');
	var name=document.getElementById('ContestantName');
	surname.classList.remove('ContentEditable');
	name.classList.remove('ContentEditable');
	surname.setAttribute('contenteditable','false');
	name.setAttribute('contenteditable','false');
}

function ModifyContestantName() {
	StartModifying();
	var surname=document.getElementById('ContestantSurname');
	var name=document.getElementById('ContestantName');
	surname.dataset.old_value=surname.innerHTML;
	name.dataset.old_value=name.innerHTML;
}

function ProcessServerAnswer( Response ) {
	if ( Response.type == 'bad' ) CancelModification();
	else if (Response.type == 'good' ) {
		var surname=document.getElementById('ContestantSurname');
		var name=document.getElementById('ContestantName');		
		var path=document.getElementsByClassName('PathElement');
		path[path.length-1].innerHTML = surname.innerHTML +' '+ name.innerHTML;
	}
}

function SendModification(ContestantId){
	EndModifying();
	var surname=document.getElementById('ContestantSurname');
	var name=document.getElementById('ContestantName');
	MakeAjaxRequest('../Modify/ManageContestant.php', 
	{ContestantId: ContestantId, name:name.innerHTML, surname: surname.innerHTML, type:'ChangeNameAndSurname'} , 
	ProcessServerAnswer);
}

function CancelModification(){
	EndModifying();
	var surname=document.getElementById('ContestantSurname');
	var name=document.getElementById('ContestantName');
	surname.innerHTML=surname.dataset.old_value;
	name.innerHTML=name.dataset.old_value;
	surname.dataset.old_value=null;
	name.dataset.old_value=null;
}
