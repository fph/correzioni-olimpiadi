function Clear( parent_tr ) {
	parent_tr.removeAttribute('id');
	var mark_child=parent_tr.getElementsByClassName('MarkColumn')[0];
	mark_child.innerHTML=GetDataAttribute(mark_child, "old_value");
	SetDataAttribute(mark_child, "old_value", null);
	
	var comment_child=parent_tr.getElementsByClassName('CommentColumn')[0];
	comment_child.innerHTML=GetDataAttribute(comment_child, "old_value");
	SetDataAttribute(comment_child, "old_value", null);
	
	parent_tr.getElementsByClassName('confirm_button_image')[0].classList.add('hidden');
	parent_tr.getElementsByClassName('cancel_button_image')[0].classList.add('hidden');
	
	var modify_buttons=document.getElementsByClassName("modify_button_image");
	for (i=0; i<modify_buttons.length; i++) modify_buttons[i].classList.remove('inline');
}


function MakeChanges(response){
	var parent_tr=document.getElementById('modifying');
	if (response.type=='bad') {
		var mark_child=parent_tr.getElementsByClassName('MarkColumn')[0];
		var comment_child=parent_tr.getElementsByClassName('CommentColumn')[0];
		var user_child=parent_tr.getElementsByClassName('UsernameColumn')[0];
		SetDataAttribute(mark_child, "new_value", null);
		SetDataAttribute(comment_child, "new_value", null);
		SetDataAttribute(user_child, "new_value", null);
		Clear();
	}
	else {		
		var mark_child=parent_tr.getElementsByClassName('MarkColumn')[0];
		SetDataAttribute(mark_child, "old_value", GetDataAttribute(mark_child, "new_value"));
		SetDataAttribute(mark_child, "new_value", null);
		
		var comment_child=parent_tr.getElementsByClassName('CommentColumn')[0];
		SetDataAttribute(comment_child, "old_value", GetDataAttribute(comment_child, "new_value"));
		SetDataAttribute(comment_child, "new_value", null);
		
		var user_child=parent_tr.getElementsByClassName('UsernameColumn')[0];
		user_child.innerHTML=GetDataAttribute(user_child, "new_value");
		SetDataAttribute(user_child, "new_value", null);
		
		Clear();
	}
}


function Confirm( parent_tr ){
	
	var ContestantId=GetContestantId(parent_tr);
	var ProblemId=GetProblemId(parent_tr);
	
	var mark_child=parent_tr.getElementsByClassName('MarkColumn')[0];
	var selectEl=mark_child.getElementsByClassName('mark_select')[0];
	var mark=selectEl.options[selectEl.selectedIndex].text;
	SetDataAttribute(mark_child, "new_value", mark);
	
	var comment_child=parent_tr.getElementsByClassName('CommentColumn')[0];
	var comment=comment_child.getElementsByClassName('comment_modifying')[0].innerHTML;
	SetDataAttribute(comment_child, "new_value", comment);
	
	var user_child=parent_tr.getElementsByClassName('UsernameColumn')[0];
	if ((GetDataAttribute(mark_child, "old_value"))!=mark) SetDataAttribute(user_child, "new_value", SessionUsername);
	
	else SetDataAttribute(user_child, "new_value", user_child.innerHTML);
	
	MakeAjaxRequest('../Modify/MakeCorrection.php', {ContestantId:ContestantId, ProblemId:ProblemId, mark:mark, comment:comment}, MakeChanges);
}

function OnModification( row ) {
	//~ var MarkHtml, CommentHtml;
	
	row.id='modifying';
	
	var MarkTd=row.getElementsByClassName('MarkColumn')[0];
	var MarkValue=MarkTd.innerHTML;
	SetDataAttribute(MarkTd, "old_value", MarkValue);
	
	var CommentTd=row.getElementsByClassName('CommentColumn')[0];
	var CommentValue=CommentTd.innerHTML;
	SetDataAttribute(CommentTd, "old_value", CommentValue);

	var MarkSelect=document.createElement('select');
	MarkSelect.classList.add('MarkSelect');
	for (i=0; i<=7; i++) {
		var OptionItem=document.createElement('option');
		OptionItem.value=i.toString();
		OptionItem.innerHTML=i.toString();
		MarkSelect.appendChild(OptionItem);
	}
	MarkSelect.selectedIndex=parseInt(MarkValue);

	MarkTd.replaceChild(MarkSelect,MarkTd.childNodes[0]);
	
	var NewCommentHTML;
	if (comment_HTML=='-') NewCommentHTML="<div contentEditable='true' class='comment_modifying'></div>"
	else NewCommentHTML="<div contentEditable='true' class='comment_modifying'>"+comment_HTML+"</div>"
	comment_child.innerHTML=NewCommentHTML;
	SetDataAttribute(comment_child, "old_value", comment_HTML);
	
	parent_tr.getElementsByClassName('confirm_button_image')[0].classList.remove('hidden');
	parent_tr.getElementsByClassName('cancel_button_image')[0].classList.remove('hidden');
	
	var modify_buttons=document.getElementsByClassName('modify_button_image');
	for (i=0; i<modify_buttons.length; i++) modify_buttons[i].classList.add( 'hidden' );
}
