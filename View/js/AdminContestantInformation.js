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
	document.getElementById('ContestantName').setAttribute('contenteditable','true');
	document.getElementById('ContestantSurname').setAttribute('contenteditable','true');
}

function SendModification(ContestantId){
	StandardButtons();
}

function CancelModification(ContestantId){
	StandardButtons();
}
