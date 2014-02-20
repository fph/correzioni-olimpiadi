function AddProblem(response){
	if (response.type=='good') {
		var name=document.getElementById('name_input').value;
		
		AddRow({name:name},{0:'trlink'}, null, null, 'name');
	}
}

function AddProblemRequest() {
	var name=document.getElementById('name_input').value;
	MakeAjaxRequest('../Modify/ManageContest.php', {ContestId:ContestId, name:name, type:'AddProblem'}, AddProblem);
}
