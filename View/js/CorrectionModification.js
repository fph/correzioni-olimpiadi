function Clear(row) {
	row.removeAttribute('id');
	var MarkTd=row.getElementsByClassName('MarkColumn')[0];
	MarkTd.innerHTML=GetDataAttribute(MarkTd, "old_value");
	SetDataAttribute(MarkTd, "old_value", null);
	
	var CommentTd=row.getElementsByClassName('CommentColumn')[0];
	CommentTd.innerHTML=GetDataAttribute(CommentTd, "old_value");
	SetDataAttribute(CommentTd, "old_value", null);
	
	row.getElementsByClassName('ConfirmButtonImage')[0].classList.add('hidden');
	row.getElementsByClassName('CancelButtonImage')[0].classList.add('hidden');
	
	var ModifyButtons=document.getElementsByClassName('ModifyButtonImage');
	for (i=0; i<ModifyButtons.length; i++) ModifyButtons[i].classList.remove('hidden');
}


function MakeChanges(response){
	var row=document.getElementById('modifying');
	
	var MarkTd=row.getElementsByClassName('MarkColumn')[0];
	var CommentTd=row.getElementsByClassName('CommentColumn')[0];
	var UserTd=row.getElementsByClassName('UsernameColumn')[0];
	
	if (response.type=='good') {
		SetDataAttribute(MarkTd, "old_value", GetDataAttribute(MarkTd, "new_value"));
		SetDataAttribute(CommentTd, "old_value", GetDataAttribute(CommentTd, "new_value"));
		UserTd.innerHTML=GetDataAttribute(UserTd, "new_value");
	}
	SetDataAttribute(MarkTd, "new_value", null);
	SetDataAttribute(CommentTd, "new_value", null);
	SetDataAttribute(UserTd, "new_value", null);
	Clear(row);
}


function Confirm(row){
	var ContestantId=GetContestantId(row);
	var ProblemId=GetProblemId(row);
	
	var MarkTd=row.getElementsByClassName('MarkColumn')[0];
	var MarkSelect=MarkTd.getElementsByClassName('MarkSelect')[0];
	var mark=MarkSelect.value;
	SetDataAttribute(MarkTd, "new_value", mark);
	
	var CommentTd=row.getElementsByClassName('CommentColumn')[0];
	var comment=CommentTd.getElementsByClassName('ContentEditable')[0].innerHTML;
	SetDataAttribute(CommentTd, "new_value", comment);
	
	var UserTd=row.getElementsByClassName('UsernameColumn')[0];
	if ((GetDataAttribute(MarkTd, "old_value"))!=mark) SetDataAttribute(UserTd, "new_value", SessionUsername);
	else SetDataAttribute(UserTd, "new_value", UserTd.innerHTML);
	
	MakeAjaxRequest('../Modify/MakeCorrection.php', {ContestantId:ContestantId, ProblemId:ProblemId, mark:mark, comment:comment}, MakeChanges);
}

function OnModification( row ) {
	
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

	var CommentEditable=document.createElement('div');
	CommentEditable.setAttribute('contenteditable', 'true');
	CommentEditable.classList.add('ContentEditable');
	CommentEditable.innerHTML=CommentValue;
	CommentTd.innerHTML='';
	CommentTd.appendChild(CommentEditable);
	
	row.getElementsByClassName('ConfirmButtonImage')[0].classList.remove('hidden');
	row.getElementsByClassName('CancelButtonImage')[0].classList.remove('hidden');
	
	var ModifyButtons=document.getElementsByClassName('ModifyButtonImage');
	for (i=0; i<ModifyButtons.length; i++) ModifyButtons[i].classList.add('hidden');
}
