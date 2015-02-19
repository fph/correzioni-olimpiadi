function Clear(row) {
	row.removeAttribute('id');
	var MarkTd=row.getElementsByClassName('MarkColumn')[0];
	MarkTd.innerHTML=GetDataAttribute(MarkTd, 'old_value');
	SetDataAttribute(MarkTd, 'old_value', null);
	
	var CommentTd=row.getElementsByClassName('CommentColumn')[0];
	CommentTd.innerHTML=GetDataAttribute(CommentTd, 'old_value');
	SetDataAttribute(CommentTd, 'old_value', null);
	
	var ModifyButtons=document.getElementsByClassName('ModifyButtonContainer');
	for (i=0; i<ModifyButtons.length; i++) ModifyButtons[i].classList.remove('hidden');
}


function MakeChanges(response){
	var row=document.getElementById('modifying');
	
	var MarkTd=row.getElementsByClassName('MarkColumn')[0];
	var CommentTd=row.getElementsByClassName('CommentColumn')[0];
	var UserTd=row.getElementsByClassName('UsernameColumn')[0];
	
	if (response.type=='good') {
		SetDataAttribute(MarkTd, 'old_value', GetDataAttribute(MarkTd, 'new_value'));
		SetDataAttribute(CommentTd, 'old_value', GetDataAttribute(CommentTd, 'new_value'));
		UserTd.innerHTML=GetDataAttribute(UserTd, 'new_value');
	}
	SetDataAttribute(MarkTd, 'new_value', null);
	SetDataAttribute(CommentTd, 'new_value', null);
	SetDataAttribute(UserTd, 'new_value', null);
	Clear(row);
}


function Confirm(row){
	var ContestantId=GetContestantId(row);
	var ProblemId=GetProblemId(row);
	
	var MarkTd=row.getElementsByClassName('MarkColumn')[0];
	var MarkSelect=MarkTd.getElementsByClassName('MarkSelect')[0];
	var mark=MarkSelect.value;
	SetDataAttribute(MarkTd, 'new_value', mark);
	
	var CommentTd=row.getElementsByClassName('CommentColumn')[0];
	var comment=CommentTd.getElementsByClassName('ContentEditable')[0].textContent; //textContent instead of innerHTML because browsers behaves differently with newlines in contentEditable
	SetDataAttribute(CommentTd, 'new_value', comment);
	
	var UserTd=row.getElementsByClassName('UsernameColumn')[0];
	if ((GetDataAttribute(MarkTd, 'old_value'))!=mark || UserTd.innerHTML=='-') SetDataAttribute(UserTd, 'new_value', SessionUsername);
	else SetDataAttribute(UserTd, 'new_value', UserTd.innerHTML);

	if (mark=='-') mark=null;
	
	MakeAjaxRequest('../Modify/MakeCorrection.php', {ContestantId:ContestantId, ProblemId:ProblemId, mark:mark, comment:comment}, MakeChanges);
}

function OnModification( row ) {
	row.id='modifying';
	
	var MarkTd=row.getElementsByClassName('MarkColumn')[0];
	var MarkValue=MarkTd.innerHTML;
	SetDataAttribute(MarkTd, 'old_value', MarkValue);
	
	var CommentTd=row.getElementsByClassName('CommentColumn')[0];
	var CommentValue=CommentTd.innerHTML;
	SetDataAttribute(CommentTd, 'old_value', CommentValue);

	var MarkSelect=document.createElement('select');
	MarkSelect.classList.add('MarkSelect');
	
	var OptionItem=document.createElement('option');
	OptionItem.value='-';
	OptionItem.innerHTML='-';
	MarkSelect.appendChild(OptionItem);
	for (i=0; i<=7; i++) {
		var OptionItem=document.createElement('option');
		OptionItem.value=i.toString();
		OptionItem.innerHTML=i.toString();
		MarkSelect.appendChild(OptionItem);
	}
	if (MarkValue=='-') MarkSelect.selectedIndex=0;
	else MarkSelect.selectedIndex=parseInt(MarkValue)+1;

	MarkTd.replaceChild(MarkSelect,MarkTd.childNodes[0]);

	var CommentEditable=document.createElement('div');
	CommentEditable.setAttribute('contenteditable', 'true');
	CommentEditable.classList.add('ContentEditable');
	CommentEditable.innerHTML=CommentValue;
	CommentTd.innerHTML='';
	CommentTd.appendChild(CommentEditable);
	
	var ModifyButtons=document.getElementsByClassName('ModifyButtonContainer');
	for (i=0; i<ModifyButtons.length; i++) ModifyButtons[i].classList.add('hidden');
}
