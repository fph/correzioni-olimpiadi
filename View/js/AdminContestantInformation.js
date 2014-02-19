function RemoveContestant(){
	setTimeout(function(){Redirect('AdminContestants');},2000);
}

function RemoveContestantRequest(ContestantId){
	MakeAjaxRequest('../Modify/ManageContestant.php', {ContestantId:ContestantId, type:'remove'}, RemoveContestant);
}

function StartModifying() {
	var buttonsTitle=document.getElementsByClassName('buttons_title')[0];
	buttonsTitle.getElementsByClassName('modifyButtonContainer')[0].classList.add('hiddenButtonContainer');
	buttonsTitle.getElementsByClassName('trashButtonContainer')[0].classList.add('hiddenButtonContainer');
	buttonsTitle.getElementsByClassName('confirmButtonContainer')[0].classList.remove('hiddenButtonContainer');
	buttonsTitle.getElementsByClassName('cancelButtonContainer')[0].classList.remove('hiddenButtonContainer');
	var surname=document.getElementById('ContestantSurname');
	var name=document.getElementById('ContestantName');
	surname.classList.add('ContentEditable');
	name.classList.add('ContentEditable');
	surname.setAttribute('contenteditable','true');
	name.setAttribute('contenteditable','true');
}

function EndModifying() {
	var ButtonsTitle=document.getElementsByClassName('buttons_title')[0];
	ButtonsTitle.getElementsByClassName('modifyButtonContainer')[0].classList.remove('hiddenButtonContainer');
	ButtonsTitle.getElementsByClassName('trashButtonContainer')[0].classList.remove('hiddenButtonContainer');
	ButtonsTitle.getElementsByClassName('confirmButtonContainer')[0].classList.add('hiddenButtonContainer');
	ButtonsTitle.getElementsByClassName('cancelButtonContainer')[0].classList.add('hiddenButtonContainer');
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
	surname.dataset.OldValue=surname.innerHTML;
	name.dataset.OldValue=name.innerHTML;
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
	surname.innerHTML=surname.dataset.OldValue;
	name.innerHTML=name.dataset.OldValue;
	surname.dataset.OldValue=null;
	name.dataset.OldValue=null;
}
