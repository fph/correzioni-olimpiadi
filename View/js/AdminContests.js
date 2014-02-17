function AddContest(response){
	if (response.type=='good') {
		var tbodyEl=document.getElementsByClassName('InformationTableTbody')[0];
		var name=document.getElementById('name_input').value;
		var date=document.getElementById('date_input').value;
		
		AddRow({name:name, date:date},{0:'trlink'},'AdminContestInformation', {'contestId':response.ContestId}, 'date');
	}
}

function AddContestRequest() {
	var name=document.getElementById('name_input').value;
	var date=document.getElementById('date_input').value;
	MakeAjaxRequest('../Modify/ManageContest.php', {name:name, date:date, type:'add'}, AddContest);
}
