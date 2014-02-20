function Clear() {
	var parent_tr=document.getElementById('modifying');
	parent_tr.removeAttribute('id');
	var mark_child=parent_tr.getElementsByClassName('mark_column')[0];
	mark_child.innerHTML=mark_child.dataset.old_value;
	mark_child.dataset.old_value=null;
	
	var comment_child=parent_tr.getElementsByClassName('comment_column')[0];
	comment_child.innerHTML=comment_child.dataset.old_value;
	comment_child.dataset.old_value=null;
	
	var modify_buttons=document.getElementsByClassName("modify_button_image");
	for (i=0; i<modify_buttons.length; i++) modify_buttons[i].style['display']='inline';
	
	var modify_child=parent_tr.getElementsByClassName('modify_column')[0];
	NewModifyHTML="<div class='ButtonContainer'>";
	NewModifyHTML+="<img class='modify_button_image ButtonImage' src='../View/Images/modify_button_image.png' alt='Modifica' onclick=OnModification(this)>";
	NewModifyHTML+="</div>";
	modify_child.innerHTML=NewModifyHTML;
	
	var cancel_child=parent_tr.getElementsByClassName('cancel_column')[0];
	NewCancelHTML="<div class='ButtonContainer'> </div>";
	cancel_child.innerHTML=NewCancelHTML;
}


function MakeChanges(response){
	var parent_tr=document.getElementById('modifying');
	if (response.type=='bad') {
		var mark_child=parent_tr.getElementsByClassName('mark_column')[0];
		var comment_child=parent_tr.getElementsByClassName('comment_column')[0];
		var user_child=parent_tr.getElementsByClassName('username_column')[0];
		mark_child.dataset.new_value=null;
		comment_child.dataset.new_value=null;
		user_child.dataset.new_value=null;
		Clear();
	}
	else {		
		var mark_child=parent_tr.getElementsByClassName('mark_column')[0];
		mark_child.dataset.old_value=mark_child.dataset.new_value;
		mark_child.dataset.new_value=null;
		
		var comment_child=parent_tr.getElementsByClassName('comment_column')[0];
		comment_child.dataset.old_value=comment_child.dataset.new_value;
		comment_child.dataset.new_value=null;
		
		var user_child=parent_tr.getElementsByClassName('username_column')[0];
		user_child.innerHTML=user_child.dataset.new_value;
		user_child.dataset.new_value=null;
		
		Clear();
	}
}


function Confirm(element_this){
	var parent_tr=element_this.parentNode.parentNode.parentNode;
	
	var ContestantId=GetContestantId(parent_tr);
	var ProblemId=GetProblemId(parent_tr);
	
	var mark_child=parent_tr.getElementsByClassName('mark_column')[0];
	var selectEl=mark_child.getElementsByClassName('mark_select')[0];
	var mark=selectEl.options[selectEl.selectedIndex].text;
	mark_child.dataset.new_value=mark;
	
	var comment_child=parent_tr.getElementsByClassName('comment_column')[0];
	var comment=comment_child.getElementsByClassName('comment_modifying')[0].innerHTML;
	comment_child.dataset.new_value=comment;
	
	var user_child=parent_tr.getElementsByClassName('username_column')[0];
	if ((mark_child.dataset.old_value)!=mark) user_child.dataset.new_value=SessionUsername;
	
	else user_child.dataset.new_value=user_child.innerHTML;
	
	MakeAjaxRequest('../Modify/MakeCorrection.php', {ContestantId:ContestantId, ProblemId:ProblemId, mark:mark, comment:comment}, MakeChanges);
}

function OnModification(element_this) {
	var mark_HTML, comment_HTML;
	var parent_tr=element_this.parentNode.parentNode.parentNode;
	
	parent_tr.id='modifying';
	
	var mark_child=parent_tr.getElementsByClassName('mark_column')[0];
	mark_HTML=mark_child.innerHTML;
	
	var comment_child=parent_tr.getElementsByClassName('comment_column')[0];
	comment_HTML=comment_child.innerHTML;
	
	var confirm_child=parent_tr.getElementsByClassName('modify_column')[0];
	
	var cancel_child=parent_tr.getElementsByClassName('cancel_column')[0];
	
	var NewMarkHTML="<select class='mark_select'>";
	for (i=0; i<=7; i++) {
		if (i==mark_HTML) NewMarkHTML+="<option name ='"+i+"' selected='selected'>"+i+"</option>";
		else NewMarkHTML+="<option name ='"+i+"'>"+i+"</option>";
	}
	NewMarkHTML+="</select>";
	mark_child.innerHTML=NewMarkHTML;
	mark_child.dataset.old_value=mark_HTML;
	
	var NewCommentHTML;
	if (comment_HTML=='-') NewCommentHTML="<div contentEditable='true' class='comment_modifying'></div>"
	else NewCommentHTML="<div contentEditable='true' class='comment_modifying'>"+comment_HTML+"</div>"
	comment_child.innerHTML=NewCommentHTML;
	comment_child.dataset.old_value=comment_HTML;
	
	NewConfirmHTML="<div class='ButtonContainer'>";
	NewConfirmHTML+="<img class='ButtonImage' src='../View/Images/confirm_button_image.png' alt='Conferma' onclick=Confirm(this)>";
	NewConfirmHTML+="</div>";
	confirm_child.innerHTML=NewConfirmHTML;
	
	NewCancelHTML="<div class='ButtonContainer'>";
	NewCancelHTML+="<img class='ButtonImage' src='../View/Images/cancel_button_image.png' alt='Annulla' onclick=Clear()>";
	NewCancelHTML+="</div>";
	cancel_child.innerHTML=NewCancelHTML;
	
	var modify_buttons=document.getElementsByClassName('modify_button_image');
	for (i=0; i<modify_buttons.length; i++) modify_buttons[i].style['display']='none';
}
