function RemoveUser(){
	setTimeout(function(){Redirect('AdminUsers');},2000);
}

function RemoveUserRequest(UserId){
	MakeAjaxRequest('../Modify/ManageUser.php', {UserId:UserId, type:'remove'}, RemoveUser);
}
