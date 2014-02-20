function RemoveParticipation(response){
	if (response.type=='good') {
		var parent_tr=document.getElementById('modifying');
		parent_tr.parentNode.removeChild(parent_tr);
	}
}

function RemoveParticipationRequest(element_this){
	var parent_tr=element_this.parentNode.parentNode.parentNode;
	parent_tr.id='modifying';
	var ContestantId=parent_tr.getAttribute('value');
	var ContestId=document.getElementsByClassName('pageTitle')[0].getAttribute('value');
	MakeAjaxRequest('../Modify/ManageContestant.php', {ContestId:ContestId, ContestantId:ContestantId, type:'RemoveParticipation'}, RemoveParticipation);
}

function AddParticipation(){
	if (response.type=='good') {
		var surname=document.getElementById('surname_input').value;
		var name=document.getElementById('name_input').value;
		 
		AddRow({surname:surname, name:name}, {0:'trlink'}, null, null, 'surname', {'trash':'RemoveParticipationRequest(this)'});
	}
}

function AddParticipationRequest(){ 
	//~ DEBUG, non è così ovvio aggiungere una partecipazione, perchè il partecipante non è identificato da nome e cognome
	var surname=document.getElementById('surname_input').value;
	var name=document.getElementById('name_input').value;
	MakeAjaxRequest('../Modify/ManageContestant.php', {ContestId:ContestId, surname:surname, name:name, type:'AddParticipation'}, AddParticipation);
}
