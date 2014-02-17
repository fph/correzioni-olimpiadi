function AddUser(response){
	if (response.type=='good') {
		var tbodyEl=document.getElementsByClassName('InformationTableTbody')[0];
		var username=document.getElementById('username_input').value;
		
		AddRow({username:username},{0:'trlink'},'AdminUserInformation', {'userId':response.UserId}, 'username');
	}
}

function AddUserRequest() {
	var username=document.getElementById('username_input').value;
	var password=document.getElementById('password_input').value;
	MakeAjaxRequest('../Modify/ManageUser.php', {username:username, password:password, type:'add'}, AddUser);
}
