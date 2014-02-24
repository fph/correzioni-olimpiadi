function AddContest(response){
	if (response.type=='good') {
		var tbodyEl=document.getElementsByClassName('InformationTableTbody')[0];
		var name=document.getElementById('NameInput').value;
		var date=document.getElementById('date_DateInput').value;
		
		AddRow({name:name, date:date},{0:'trlink'},'AdminContestInformation', {'ContestId':response.ContestId}, 'date');
	}
}

function AddContestRequest() {
	var name=document.getElementById('NameInput').value;
	var date=document.getElementById('date_DateInput').value;
	MakeAjaxRequest('../Modify/ManageContest.php', {name:name, date:date, type:'add'}, AddContest);
}
