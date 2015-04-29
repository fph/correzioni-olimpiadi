function RemoveUser(){
	setTimeout(function(){Redirect('AdminUsers');},2000);
}

function DeleteTitle(){
	MakeAjaxRequest('../Modify/ManageUser.php', {UserId:UserId, type:'remove'}, RemoveUser);
}

function ModifyTitle() {
	var UsernameTitle=document.getElementById('UsernameTitle');
	UsernameTitle.classList.add('ContentEditable');
	UsernameTitle.setAttribute('contenteditable','true');
	SetDataAttribute(UsernameTitle, 'old_value', UsernameTitle.innerHTML);
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
	var UsernameTitle=document.getElementById('UsernameTitle');	
	UsernameTitle.classList.remove('ContentEditable');
	UsernameTitle.setAttribute('contenteditable','false');
	MakeAjaxRequest('../Modify/ManageUser.php', 
	{UserId: UserId, username:UsernameTitle.innerHTML, type:'ChangeUsername'} , 
	ProcessServerAnswer);
}

function CancelTitleModification(){
	var UsernameTitle=document.getElementById('UsernameTitle');	
	UsernameTitle.classList.remove('ContentEditable');
	UsernameTitle.setAttribute('contenteditable','false');
	UsernameTitle.innerHTML=GetDataAttribute(UsernameTitle, 'old_value');
	SetDataAttribute(UsernameTitle, 'old_value', null);
}


function CancelUserRole(){
	var container=document.getElementById('UserRoleContainer');
	var span=document.getElementById('UserRoleSpan');
	var select=document.getElementById('UserRoleSelect');
	
	span.classList.remove('hidden');
	select.classList.add('hidden');
	
	SetDataAttribute(container, 'old_value', null);
}

function MakeChangesUserRole(response){
	var container=document.getElementById('UserRoleContainer');
	var span=document.getElementById('UserRoleSpan');
	var select=document.getElementById('UserRoleSelect');
	
	if (response.type=='good') {
		var value=GetDataAttribute(container, 'new_value');
		SetDataAttribute(container, 'value', value);
		SetDataAttribute(container, 'new_value', null);
		SetDataAttribute(container, 'old_value', null);
		select.classList.add('hidden');
		
		//TODO: Ad essere pignoli, quando si diventa admin o SuperAdmin dovrebbero scomparire i bottoni per cambiare il nome del correttore. Attualmente non è implementato perché è una noia e sarebbe una cosa notata solo da SuperAdmin (anche raramente).
		if(value=='user') span.textContent='Correttore';
		else if(value=='admin') span.textContent='Amministratore';
		else if(value=='SuperAdmin') {
			span.textContent='Super amministratore';
			var buttons=container.getElementsByClassName('ButtonsSubtitle')[0];
			buttons.parentNode.removeChild(buttons);
		}
		
		span.classList.remove('hidden');
	}
	else {
		CancelUserRole();
	}
}

function ConfirmUserRole(){
	var container=document.getElementById('UserRoleContainer');
	var span=document.getElementById('UserRoleSpan');
	var select=document.getElementById('UserRoleSelect');
	
	var NewValue=select.options[select.selectedIndex].value;
	SetDataAttribute(container, 'new_value', NewValue);
	MakeAjaxRequest('../Modify/ManageUser.php', {UserId: UserId, type: 'ChangeRole', UserRole: NewValue}, MakeChangesUserRole);
}

function ModifyUserRole(){
	var container=document.getElementById('UserRoleContainer');
	var span=document.getElementById('UserRoleSpan');
	var select=document.getElementById('UserRoleSelect');
	
	span.classList.add('hidden');
	
	var value=GetDataAttribute(container, 'value');
	if(value=='user') select.selectedIndex=0;
	else if(value=='admin') select.selectedIndex=1;
	else if(value=='SuperAdmin') select.selectedIndex=2;
	select.classList.remove('hidden');
}
