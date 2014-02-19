function RemoveContestant(){
	setTimeout(function(){Redirect('AdminContestants');},2000);
}

function RemoveContestantRequest(ContestantId){
	MakeAjaxRequest('../Modify/ManageContestant.php', {ContestantId:ContestantId, type:'remove'}, RemoveContestant);
}

function ModificationButtons() {
	var buttonsTitle=document.getElementsByClassName('buttons_title')[0];
	buttonsTitle.getElementsByClassName('modifyButtonContainer')[0].classList.add('hiddenButtonContainer');
	buttonsTitle.getElementsByClassName('trashButtonContainer')[0].classList.add('hiddenButtonContainer');
	buttonsTitle.getElementsByClassName('confirmButtonContainer')[0].classList.remove('hiddenButtonContainer');
	buttonsTitle.getElementsByClassName('cancelButtonContainer')[0].classList.remove('hiddenButtonContainer');
}

function StandardButtons() {
	var buttonsTitle=document.getElementsByClassName('buttons_title')[0];
	buttonsTitle.getElementsByClassName('modifyButtonContainer')[0].classList.remove('hiddenButtonContainer');
	buttonsTitle.getElementsByClassName('trashButtonContainer')[0].classList.remove('hiddenButtonContainer');
	buttonsTitle.getElementsByClassName('confirmButtonContainer')[0].classList.add('hiddenButtonContainer');
	buttonsTitle.getElementsByClassName('cancelButtonContainer')[0].classList.add('hiddenButtonContainer');
}

function ModifyContestantName() {
	ModificationButtons();
	var surname=document.getElementById('ContestantSurname');
	var name=document.getElementById('ContestantName');
	surname.setAttribute('contenteditable','true');
	name.setAttribute('contenteditable','true');
	surname.dataset.OldValue=surname.innerHTML;
	name.dataset.OldValue=name.innerHTML;
}

function SendModification(ContestantId){
	StandardButtons();
	var surname=document.getElementById('ContestantSurname');
	var name=document.getElementById('ContestantName');
	surname.setAttribute('contenteditable','false');
	name.setAttribute('contenteditable','false');
	// Mandare la richiesta al server!
}

function CancelModification(ContestantId){
	StandardButtons();
	var surname=document.getElementById('ContestantSurname');
	var name=document.getElementById('ContestantName');
	surname.setAttribute('contenteditable','false');
	name.setAttribute('contenteditable','false');
	surname.innerHTML=surname.dataset.OldValue;
	name.innerHTML=name.dataset.OldValue;
	surname.dataset.OldValue=null;
	name.dataset.OldValue=null;
}
