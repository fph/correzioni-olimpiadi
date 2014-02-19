function RemoveContest(){
	setTimeout(function(){Redirect('AdminContests');},2000);
}

function RemoveContestRequest(ContestId){
	MakeAjaxRequest('../Modify/ManageContest.php', {ContestId:ContestId, type:'remove'}, RemoveContest);
}
