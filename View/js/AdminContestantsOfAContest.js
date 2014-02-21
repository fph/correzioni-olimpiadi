function RemoveParticipation(response){
	if (response.type=='good') {
		parent_tr=document.getElementById('trashing'+response.ContestantId);
		var tbodyEl=parent_tr.parentNode;
		tbodyEl.removeChild(parent_tr);
		var childs=tbodyEl.getElementsByTagName('tr');
		if (childs.length<1) {
			var EmptyTable=document.getElementsByClassName('EmptyTable')[0];
			EmptyTable.classList.remove('hidden');
			var InformationTable=document.getElementsByClassName('InformationTable')[0];
			InformationTable.classList.add('hidden');
		}
	}
}

function RemoveParticipationRequest(element_this){
	var parent_tr=element_this.parentNode.parentNode.parentNode;
	var ContestantId=GetDataAttribute(parent_tr, "contestant_id");
	parent_tr.id='trashing'+ContestantId;
	MakeAjaxRequest('../Modify/ManageContestant.php', {ContestId:ContestId, ContestantId:ContestantId, type:'RemoveParticipation'}, RemoveParticipation);
}

function AddParticipation(response){
	if (response.type=='good') {
		var surname=document.getElementById('surname_input').value;
		var name=document.getElementById('name_input').value;
		AddRow({surname:surname, name:name}, null, null, null, 'surname', {'trash':'RemoveParticipationRequest(this)'}, {'contestant_id':response.ContestantId});
	}
}

function AddParticipationRequest(){ 
	var surname=document.getElementById('surname_input').value;
	var name=document.getElementById('name_input').value;
	MakeAjaxRequest('../Modify/ManageContestant.php', {ContestId:ContestId, surname:surname, name:name, type:'AddParticipation'}, AddParticipation);
}
