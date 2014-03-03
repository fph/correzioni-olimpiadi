function AddUser(response){
	if (response.type=='good') {
		var username=response.data['username'];
		var UserId=response.data['UserId'];

		AddRow( document.getElementById('AdminUsersTable'),
		{	redirect:{'UserId':UserId},
			values:{'username':username} },
			'username');
	}
}

function AddUserRequest() {
	var username=document.getElementById('UsernameInput').value;
	var password=document.getElementById('PasswordInput').value;
	MakeAjaxRequest('../Modify/ManageUser.php', {username:username, password:password, type:'add'}, AddUser);
}
