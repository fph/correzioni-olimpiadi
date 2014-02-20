function AddProblem(response){
	if (response.type=='good') {
		var name=document.getElementById('name_input').value;
		
		AddRow({name:name},null, null, null, 'name', {'trash':'RemoveProblemRequest(this)'});
	}
}

function AddProblemRequest() {
	var name=document.getElementById('name_input').value;
	MakeAjaxRequest('../Modify/ManageContest.php', {ContestId:ContestId, name:name, type:'AddProblem'}, AddProblem);
}

function RemoveProblem(response){
	if (response.type=='good') {
		parent_tr=document.getElementById('trashing'+response.id);
		parent_tr.parentNode.removeChild(parent_tr);
	}
}

function RemoveProblemRequest(element_this) {
	var parent_tr=element_this.parentNode.parentNode.parentNode;
	var ProblemId=parent_tr.dataset.problem_id;
	parent_tr.id='trashing'+ProblemId;
	MakeAjaxRequest('../Modify/ManageContest.php', {ProblemId:ProblemId, type:'RemoveProblem'}, RemoveProblem);
}
