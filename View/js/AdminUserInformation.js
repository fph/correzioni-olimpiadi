function RemoveUser(){
	setTimeout(function(){Redirect('AdminUsers');},2000);
}

function DeleteTitle(){
	MakeAjaxRequest('../Modify/ManageUser.php', {UserId:UserId, type:'remove'}, RemoveUser);
}

function ModifyTitle() {
	StartModifyingTitle();
	var UsernameTitle=document.getElementById('UsernameTitle');
	UsernameTitle.classList.add('ContentEditable');
	UsernameTitle.setAttribute('contenteditable','true');
	UsernameTitle.dataset.old_value=UsernameTitle.innerHTML;
}

function ProcessServerAnswer( Response ) {
	if ( Response.type == 'bad' ) CancelTitleModification();
	else if (Response.type == 'good' ) {
		var UsernameTitle=document.getElementById('UsernameTitle');	
		var path=document.getElementsByClassName('PathElement');
		path[path.length-1].innerHTML = UsernameTitle.innerHTML;
	}
}

function SendTitleModification(){
	EndModifyingTitle();
	var UsernameTitle=document.getElementById('UsernameTitle');	
	UsernameTitle.classList.remove('ContentEditable');
	UsernameTitle.setAttribute('contenteditable','false');
	MakeAjaxRequest('../Modify/ManageUser.php', 
	{UserId: UserId, username:UsernameTitle.innerHTML, type:'ChangeUsername'} , 
	ProcessServerAnswer);
}

function CancelTitleModification(){
	EndModifyingTitle();
	var UsernameTitle=document.getElementById('UsernameTitle');	
	UsernameTitle.classList.remove('ContentEditable');
	UsernameTitle.setAttribute('contenteditable','false');
	UsernameTitle.innerHTML=UsernameTitle.dataset.old_value;
	UsernameTitle.dataset.old_value=null;
}
