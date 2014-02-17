function AddUser(response){
	//~ if (response.type=='good') {
		//~ var tbodyEl=document.getElementsByClassName('InformationTableTbody')[0];
		//~ var surname=document.getElementById('surname_input').value;
		//~ var name=document.getElementById('name_input').value;
		//~ 
		//~ AddRow({surname:surname, name:name},{0:'trlink'},'AdminContestantInformation', {'contestantId':response.ContestantId}, 'surname');
	//~ }
}

function AddUserRequest() {
	var username=document.getElementById('username_input').value;
	MakeAjaxRequest('../Modify/ManageUser.php', {username:username, type:'add'}, AddContestant);
	//~ var surname=document.getElementById('surname_input').value;
	//~ var name=document.getElementById('name_input').value;
	//~ MakeAjaxRequest('../Modify/ManageContestant.php', {surname:surname, name:name, type:'add'}, AddContestant);
}
