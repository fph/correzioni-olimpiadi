function RemoveContest(){
	setTimeout(function(){Redirect('AdminContests');},2000);
}

function DeleteTitle(){
	MakeAjaxRequest('../Modify/ManageContest.php', {ContestId:ContestId, type:'remove'}, RemoveContest);
}

function ModifyTitle() {
	StartModifyingTitle();
	var NameTitle=document.getElementById('name_title');
	var DateTitle=document.getElementById();
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
