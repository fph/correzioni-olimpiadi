function AddProblem(response){
	if (response.type=='good') {
		var tbodyEl=document.getElementsByClassName('InformationTableTbody')[0];
		var name=document.getElementById('name_input').value;
		
		AddRow({name:name},{0:'trlink'}, null, null, 'name');
	}
}

function AddProblemRequest() {
	var name=document.getElementById('name_input').value;
	var ContestId=document.getElementsByClassName('pageTitle')[0].getAttribute('value');
	alert(name);
	MakeAjaxRequest('../Modify/ManageContest.php', {ContestId:ContestId, name:name, type:'AddProblem'}, AddProblem);
}
