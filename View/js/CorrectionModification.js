function Clear() {
	var parent_tr=document.getElementById('modifying');
	parent_tr.removeAttribute('id');
	var markChild=parent_tr.getElementsByClassName('markColumn')[0];
	markChild.innerHTML=document.getElementById('hiddenMarkHTML').value;
	
	var commentChild=parent_tr.getElementsByClassName('commentColumn')[0];
	commentChild.innerHTML=document.getElementById('hiddenCommentHTML').value;
	
	var modifyButtons=document.getElementsByClassName("modifyButtonImage");
	for (i=0; i<modifyButtons.length; i++) modifyButtons[i].style["display"]='inline';
	
	var modifyChild=parent_tr.getElementsByClassName('modifyColumn')[0];
	newModifyHTML="<td class='modifyColumn'> <div class='modifyButtonContainer buttonContainer'>";
	newModifyHTML+="<img class='modifyButtonImage buttonImage' src='../View/Images/ModifyButtonImage.png' alt='Modifica' onclick=OnModification(this)>";
	newModifyHTML+="</div> </td>";
	modifyChild.innerHTML=newModifyHTML;
	
	var cancelChild=parent_tr.getElementsByClassName('cancelColumn')[0];
	newCancelHTML="<div class='cancelButtonContainer buttonContainer'> </div>";
	cancelChild.innerHTML=newCancelHTML;
}


function MakeChanges(response){
	if (response.type=='bad') {
		var userHiddenDiv=document.getElementById('hiddenUserHTML');
		userHiddenDiv.parentNode.removeChild(userHiddenDiv);
		Clear();
	}
	else {
		var parent_tr=document.getElementById('modifying');
		
		var markChild=parent_tr.getElementsByClassName('markColumn')[0];
		var selectEl=markChild.getElementsByClassName('selectMark')[0];
		var mark=selectEl.options[selectEl.selectedIndex].text;
		
		var commentChild=parent_tr.getElementsByClassName('commentColumn')[0];
		var comment=commentChild.getElementsByClassName('modifyComment')[0].innerHTML;
		
		var hiddenMarkDiv=document.getElementById('hiddenMarkHTML');
		var hiddenCommentDiv=document.getElementById('hiddenCommentHTML')
		
		var userHiddenDiv=document.getElementById('hiddenUserHTML');
		if (hiddenMarkDiv.value!=mark) parent_tr.getElementsByClassName('usernameColumn')[0].innerHTML=userHiddenDiv.value;
		else userHiddenDiv.parentNode.removeChild(userHiddenDiv);
		
		hiddenMarkDiv.value=mark;
		hiddenCommentDiv.value=comment;
		
		Clear();
	}
}


function Confirm(element_this){
	var parent_tr=element_this.parentNode.parentNode.parentNode;
	
	var ContestantId=getContestantId(parent_tr);
	var ProblemId=getProblemId(parent_tr);
	
	var markChild=parent_tr.getElementsByClassName('markColumn')[0];
	var selectEl=markChild.getElementsByClassName('selectMark')[0];
	var mark=selectEl.options[selectEl.selectedIndex].text;
	var previousMark=document.getElementById('hiddenMarkHTML').value;
	
	var commentChild=parent_tr.getElementsByClassName('commentColumn')[0];
	var comment=commentChild.getElementsByClassName('modifyComment')[0].innerHTML;
	
	var userChild=parent_tr.getElementsByClassName('usernameColumn')[0];
	var user=userChild.innerHTML;
	if (previousMark!=mark) userChild.innerHTML+="<input type='hidden' id='hiddenUserHTML' value='"+SessionUsername+"'>";
	else userChild.innerHTML+="<input type='hidden' id='hiddenUserHTML' value='"+user+"'>";
	
	MakeAjaxRequest('../Modify/MakeCorrection.php', {ContestantId:ContestantId, ProblemId:ProblemId, mark:mark, comment:comment}, MakeChanges);
}

function OnModification(element_this) {
	var markHTML, commentHTML;
	var parent_tr=element_this.parentNode.parentNode.parentNode;
	
	parent_tr.id='modifying';
	
	var markChild=parent_tr.getElementsByClassName('markColumn')[0];
	markHTML=markChild.innerHTML;
	
	var commentChild=parent_tr.getElementsByClassName('commentColumn')[0];
	commentHTML=commentChild.innerHTML;
	
	var confirmChild=parent_tr.getElementsByClassName('modifyColumn')[0];
	
	var cancelChild=parent_tr.getElementsByClassName('cancelColumn')[0];
	
	var newMarkHTML="<select class='selectMark'>";
	for (i=0; i<=7; i++) {
		if (i==markHTML) newMarkHTML+="<option name ='"+i+"' selected='selected'>"+i+"</option>";
		else newMarkHTML+="<option name ='"+i+"'>"+i+"</option>";
	}
	newMarkHTML+="</select>";
	newMarkHTML+="<input type='hidden' id='hiddenMarkHTML' value='"+markHTML+"'>";
	markChild.innerHTML=newMarkHTML;
	
	var newCommentHTML;
	if (commentHTML=='-') newCommentHTML="<div contentEditable='true' class='modifyComment'></div>"
	else newCommentHTML="<div contentEditable='true' class='modifyComment'>"+commentHTML+"</div>"
	newCommentHTML+="<input type='hidden' id='hiddenCommentHTML' value='"+commentHTML+"'>";
	commentChild.innerHTML=newCommentHTML;
	
	newConfirmHTML="<div class='confirmButtonContainer buttonContainer'>";
	newConfirmHTML+="<img class='confirmButtonImage buttonImage' src='../View/Images/ConfirmButtonImage.png' alt='Conferma' onclick=Confirm(this)>";
	newConfirmHTML+="</div>";
	confirmChild.innerHTML=newConfirmHTML;
	
	newCancelHTML="<div class='cancelButtonContainer buttonContainer'>";
	newCancelHTML+="<img class='cancelButtonImage buttonImage' src='../View/Images/CancelButtonImage.png' alt='Annulla' onclick=Clear()>";
	newCancelHTML+="</div>";
	cancelChild.innerHTML=newCancelHTML;
	
	var modifyButtons=document.getElementsByClassName("modifyButtonImage");
	for (i=0; i<modifyButtons.length; i++) modifyButtons[i].style["display"]='none';
}
