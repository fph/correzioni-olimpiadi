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
