function AddProblem(response){
	if (response.type=='good') {
		var problem=document.getElementById('problem_input').value;
		
		AddRow({problem:problem},null, null, null, 'problem', {'modify':'OnModification(this)','trash':'RemoveProblemRequest(this)'}, {'problem_id':response.ProblemId});
	}
}

function AddProblemRequest() {
	var problem=document.getElementById('problem_input').value;
	MakeAjaxRequest('../Modify/ManageContest.php', {ContestId:ContestId, name:problem, type:'AddProblem'}, AddProblem);
}

function RemoveProblem(response){
	if (response.type=='good') {
		parent_tr=document.getElementById('trashing'+response.ProblemId);
		var tbodyEl=parent_tr.parentNode;
		tbodyEl.removeChild(parent_tr);
		var childs=tbodyEl.getElementsByTagName('tr');
		if (childs.length<1) {
			var EmptyTable=document.getElementsByClassName('EmptyTable')[0];
			EmptyTable.classList.remove('hidden');
			var InformationTable=document.getElementsByClassName('InformationTable')[0];
			InformationTable.classList.add('hidden');
		}
	}
}

function RemoveProblemRequest(element_this) {
	var parent_tr=element_this.parentNode.parentNode.parentNode;
	var ProblemId=parent_tr.dataset.problem_id;
	parent_tr.id='trashing'+ProblemId;
	MakeAjaxRequest('../Modify/ManageContest.php', {ProblemId:ProblemId, type:'RemoveProblem'}, RemoveProblem);
}

function Clear(){
	var parent_tr=document.getElementById('modifying');
	parent_tr.removeAttribute('id');

	var problem_child=parent_tr.getElementsByClassName('problem_column')[0];
	problem_child.innerHTML=problem_child.dataset.old_value;
	problem_child.dataset.old_value=null;

	var modify_buttons=document.getElementsByClassName('modify_button_image');
	for (i=0; i<modify_buttons.length; i++) modify_buttons[i].classList.remove('hidden');
	
	var trash_buttons=document.getElementsByClassName('trash_button_image');
	for (i=0; i<trash_buttons.length; i++) trash_buttons[i].classList.remove('hidden');
	
	var modify_child=parent_tr.getElementsByClassName('modify_column')[0];
	NewModifyHTML="<div class='ButtonContainer'>";
	NewModifyHTML+="<img class='modify_button_image ButtonImage' src='../View/Images/modify_button_image.png' alt='Modifica' onclick='OnModification(this)'>";
	NewModifyHTML+="</div>";
	modify_child.innerHTML=NewModifyHTML;

	var trash_child=parent_tr.getElementsByClassName('trash_column')[0];
	NewTrashHTML="<div class='ButtonContainer'>";
	NewTrashHTML+="<img class='trash_button_image ButtonImage' src='../View/Images/trash_button_image.png' alt='Elimina' onclick='RemoveProblemRequest(this)'>";
	NewTrashHTML+="</div>";
	trash_child.innerHTML=NewTrashHTML;

	var add_button=document.getElementById('button_input');
	add_button.removeAttribute('disabled','disabled');
}

function MakeChanges(response){
	var parent_tr=document.getElementById('modifying');
	var problem_child=parent_tr.getElementsByClassName('problem_column')[0];
	if (response.type=='bad') {
		problem_child.dataset.new_value=null;
		Clear();
	}
	else {
		problem_child.dataset.old_value=problem_child.dataset.new_value;
		problem_child.dataset.new_value=null;
		
		Clear();
	}
}

function Confirm(element_this) {
	var parent_tr=element_this.parentNode.parentNode.parentNode;
	
	var problem_child=parent_tr.getElementsByClassName('problem_column')[0];
	
	var problem_name=problem_child.getElementsByClassName('ContentEditable')[0].innerHTML;
	problem_child.dataset.new_value=problem_name;

	var ProblemId=parent_tr.dataset.problem_id;
	
	MakeAjaxRequest('../Modify/ManageContest.php', {type:'ChangeProblemName', name:problem_name, ProblemId:ProblemId}, MakeChanges);
}


function OnModification(element_this){
	var parent_tr=element_this.parentNode.parentNode.parentNode;

	parent_tr.id='modifying';

	var problem_child=parent_tr.getElementsByClassName('problem_column')[0];

	problem_child.dataset.old_value=problem_child.innerHTML;
	problem_child.innerHTML="<div contentEditable='true' class='ContentEditable'>"+problem_child.innerHTML+"</div>"

	var confirm_child=parent_tr.getElementsByClassName('modify_column')[0];
	var cancel_child=parent_tr.getElementsByClassName('trash_column')[0];

	NewConfirmHTML="<div class='ButtonContainer'>";
	NewConfirmHTML+="<img class='ButtonImage' src='../View/Images/confirm_button_image.png' alt='Conferma' onclick=Confirm(this)>";
	NewConfirmHTML+="</div>";
	confirm_child.innerHTML=NewConfirmHTML;

	NewCancelHTML="<div class='ButtonContainer'>";
	NewCancelHTML+="<img class='ButtonImage' src='../View/Images/cancel_button_image.png' alt='Annulla' onclick=Clear()>";
	NewCancelHTML+="</div>";
	cancel_child.innerHTML=NewCancelHTML;

	var modify_buttons=document.getElementsByClassName('modify_button_image');
	for (i=0; i<modify_buttons.length; i++) modify_buttons[i].classList.add('hidden');
	
	var trash_buttons=document.getElementsByClassName('trash_button_image');
	for (i=0; i<trash_buttons.length; i++) trash_buttons[i].classList.add('hidden');

	var add_button=document.getElementById('button_input');
	add_button.setAttribute('disabled','disabled');
}
