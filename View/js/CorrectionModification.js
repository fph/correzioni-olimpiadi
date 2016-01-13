function Clear(row) {
	row.removeAttribute('id');
	var MarkTd = row.getElementsByClassName('MarkColumn')[0];
	MarkTd.innerHTML = GetDataAttribute(MarkTd, 'old_value');
	SetDataAttribute(MarkTd, 'old_value', null);
	
	var CommentTd = row.getElementsByClassName('CommentColumn')[0];
	CommentTd.innerHTML = GetDataAttribute(CommentTd, 'old_value');
	SetDataAttribute(CommentTd, 'old_value', null);
	
	var ModifyButtons = document.getElementsByClassName('ModifyButtonContainer');
	for (i = 0; i < ModifyButtons.length; i++) ModifyButtons[i].classList.remove('hidden');
}


function MakeChanges(response) {
	var row = document.getElementById('modifying');
	
	var MarkTd = row.getElementsByClassName('MarkColumn')[0];
	var CommentTd = row.getElementsByClassName('CommentColumn')[0];
	var UserTd = row.getElementsByClassName('UsernameColumn')[0];
	
	if (response.type == 'good') {
		SetDataAttribute(MarkTd, 'old_value', GetDataAttribute(MarkTd, 'new_value'));
		
		// old_value is escaped, instead new_value is not.
		// Here new_value is escaped and assigned to old_value
		var UnescapedComment = GetDataAttribute(CommentTd, 'new_value');
		var EscapedComment = UnescapedComment
			.replace(/&/g, "&amp;")
			.replace(/</g, "&lt;")
			.replace(/>/g, "&gt;")
			.replace(/"/g, "&quot;")
			.replace(/'/g, "&#039;")
			.replace(/\//g, "&#x2F;");
		SetDataAttribute(CommentTd, 'old_value', EscapedComment);
		
		UserTd.innerHTML=GetDataAttribute(UserTd, 'new_value');
	}
	SetDataAttribute(MarkTd, 'new_value', null);
	SetDataAttribute(CommentTd, 'new_value', null);
	SetDataAttribute(UserTd, 'new_value', null);
	Clear(row);
}


function Confirm(row) {
	var ContestantId = GetContestantId(row);
	var ProblemId = GetProblemId(row);
	
	var MarkTd = row.getElementsByClassName('MarkColumn')[0];
	var MarkSelect = MarkTd.getElementsByClassName('MarkSelect')[0];
	var mark = MarkSelect.value;
	SetDataAttribute(MarkTd, 'new_value', (mark == '-1')?'∅':mark);
	
	var CommentTd = row.getElementsByClassName('CommentColumn')[0];
	// textContent is used instead of innerHTML because browsers behaves differently with newlines in contentEditable
	// But textContent unescapes html special chars, and this fact is handled in MakeChanges
	// and not here as it is better to leave the comment unescaped, otherwise it 
	// would be doubly escaped (once client-side, once server-side) 
	var comment = CommentTd.getElementsByClassName('ContentEditable')[0].textContent;
	SetDataAttribute(CommentTd, 'new_value', comment);
	
	var UserTd = row.getElementsByClassName('UsernameColumn')[0];
	if ((GetDataAttribute(MarkTd, 'old_value')) != mark || UserTd.innerHTML == '-') SetDataAttribute(UserTd, 'new_value', SessionUsername);
	else SetDataAttribute(UserTd, 'new_value', UserTd.innerHTML);

	if (mark == '-') mark = null;
	
	MakeAjaxRequest('../Modify/MakeCorrection.php', {ContestantId: ContestantId, ProblemId: ProblemId, mark: mark, comment: comment}, MakeChanges);
}

function OnModification(row) {
	row.id='modifying';
	
	var MarkTd = row.getElementsByClassName('MarkColumn')[0];
	var MarkValue = MarkTd.innerHTML;
	SetDataAttribute(MarkTd, 'old_value', MarkValue);
	
	var CommentTd = row.getElementsByClassName('CommentColumn')[0];
	var CommentValue = CommentTd.innerHTML;
	SetDataAttribute(CommentTd, 'old_value', CommentValue);

	var MarkSelect = document.createElement('select');
	MarkSelect.classList.add('MarkSelect');
	
	var NullOption = document.createElement('option');
	NullOption.value = '-';
	NullOption.innerHTML = '-';
	MarkSelect.appendChild(NullOption);
	
	var EmptyOption = document.createElement('option');
	EmptyOption.value = '-1';
	EmptyOption.innerHTML = '∅';
	MarkSelect.appendChild(EmptyOption);
	
	for (i=0.0; i <= 7.0; i+=0.5) {
		var OptionItem = document.createElement('option');
		OptionItem.value = i.toString();
		OptionItem.innerHTML = i.toString();
		MarkSelect.appendChild(OptionItem);
	}
	console.log(MarkValue[0]);
	if (MarkValue == '-') MarkSelect.selectedIndex = 0;
	else if (MarkValue == '∅') MarkSelect.selectedIndex = 1
	else MarkSelect.selectedIndex = 2+parseInt(parseFloat(MarkValue)*2);

	MarkTd.replaceChild(MarkSelect, MarkTd.childNodes[0]);

	var CommentEditable = document.createElement('div');
	CommentEditable.setAttribute('contenteditable', 'true');
	CommentEditable.classList.add('ContentEditable');
	CommentEditable.innerHTML=CommentValue;
	CommentTd.innerHTML='';
	CommentTd.appendChild(CommentEditable);
	
	var ModifyButtons = document.getElementsByClassName('ModifyButtonContainer');
	for (i=0; i<ModifyButtons.length; i++) ModifyButtons[i].classList.add('hidden');
}
