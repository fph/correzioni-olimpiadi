function RemovePermission(response){
	if (response.type=='good') {
		var UserId=response.data['UserId'];
		var row=document.getElementById('trashing'+UserId); //Questa storia della riga non è pulitissima
		RemoveRow(document.getElementById('AdminUsersOfAContestTable'), row);
	}
}

function RemovePermissionRequest(row){
	var UserId=GetDataAttribute(row, 'user_id');
	row.id='trashing'+UserId;
	MakeAjaxRequest('../Modify/ManageUser.php', {ContestId:ContestId, UserId:UserId, type:'RemovePermission'}, RemovePermission);
}

function AddPermission(response){
	if (response.type=='good') {
		var username=response.data['username'];
		var UserId=response.data['UserId'];
		AddRow(document.getElementById('AdminUsersOfAContestTable'),{
			data:{'user_id':UserId},
			values:{'username':username}
		},'username');
	}
}

function AddPermissionRequest(){ 
	var UserId=GetSelectValue('UserInput');
	MakeAjaxRequest('../Modify/ManageUser.php', {ContestId:ContestId, UserId:UserId, type:'AddPermission'}, AddPermission);
}
