function AddUser(response){
	if (response.type=='good') {
		var username=document.getElementById('UsernameInput').value;
		
		AddRow({username:username},{0:'trlink'},'AdminUserInformation', {'UserId':response.UserId}, 'username');
	}
}

function AddUserRequest() {
	var username=document.getElementById('UsernameInput').value;
	var password=document.getElementById('PasswordInput').value;
	MakeAjaxRequest('../Modify/ManageUser.php', {username:username, password:password, type:'add'}, AddUser);
}
