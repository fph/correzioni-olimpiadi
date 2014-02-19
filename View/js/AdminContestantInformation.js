function RemoveContestant(){
	setTimeout(function(){Redirect('AdminContestants');},2000);
}

function RemoveContestantRequest(ContestantId){
	MakeAjaxRequest('../Modify/ManageContestant.php', {ContestantId:ContestantId, type:'remove'}, RemoveContestant);
}
