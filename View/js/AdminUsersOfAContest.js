function RemovePermission(response){
	if (response.type=='good') {
		parent_tr=document.getElementById('trashing'+response.UserId);
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

function RemovePermissionRequest(element_this){
	var parent_tr=element_this.parentNode.parentNode.parentNode;
	var UserId=GetDataAttribute(parent_tr, "user_id");
	parent_tr.id='trashing'+UserId;
	MakeAjaxRequest('../Modify/ManageUser.php', {ContestId:ContestId, UserId:UserId, type:'RemovePermission'}, RemovePermission);
}

function AddPermission(response){
	if (response.type=='good') {
		var username=document.getElementById('username_input').value;
		AddRow({username:username}, null, null, null, 'username', {'trash':'RemovePermissionRequest(this)'}, {'user_id':response.UserId});
	}
}

function AddPermissionRequest(){ 
	var username=document.getElementById('username_input').value;
	MakeAjaxRequest('../Modify/ManageUser.php', {ContestId:ContestId, username:username, type:'AddPermission'}, AddPermission);
}