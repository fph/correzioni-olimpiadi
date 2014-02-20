function AddUser(response){
	if (response.type=='good') {
		var username=document.getElementById('username_input').value;
		
		AddRow({username:username},{0:'trlink'},'AdminUserInformation', {'UserId':response.UserId}, 'username');
	}
}

function AddUserRequest() {
	var username=document.getElementById('username_input').value;
	var password=document.getElementById('password_input').value;
	MakeAjaxRequest('../Modify/ManageUser.php', {username:username, password:password, type:'add'}, AddUser);
}
