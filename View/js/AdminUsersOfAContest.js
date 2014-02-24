function RemovePermission(response){
	if (response.type=='good') {
		row=document.getElementById('trashing'+response.UserId);
		RemoveRow(document.getElementById('AdminUsersOfAContestTable'), row);
	}
}

function RemovePermissionRequest(row){
	var UserId=GetDataAttribute(row, "user_id");
	row.id='trashing'+UserId;
	MakeAjaxRequest('../Modify/ManageUser.php', {ContestId:ContestId, UserId:UserId, type:'RemovePermission'}, RemovePermission);
}

function AddPermission(response){
	if (response.type=='good') {
		var username=document.getElementById('UsernameInput').value;
		AddRow(document.getElementById('AdminUsersOfAContestTable'),{
			data:{'user_id':response.UserId},
			values:{'username':username}
		},'username');
	}
}

function AddPermissionRequest(){ 
	var username=document.getElementById('UsernameInput').value;
	MakeAjaxRequest('../Modify/ManageUser.php', {ContestId:ContestId, username:username, type:'AddPermission'}, AddPermission);
}
