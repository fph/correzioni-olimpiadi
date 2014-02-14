var markHTML;
var commentHTML;

function Clear(element_this) {
	var parent_tr=element_this.parentNode.parentNode.parentNode;
	var markChild=parent_tr.getElementsByClassName('markColumn')[0];
	markChild.innerHTML=markHTML;
	
	var commentChild=parent_tr.getElementsByClassName('commentColumn')[0];
	commentChild.innerHTML=commentHTML;
	
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


function Confirm(element_this){
	var parent_tr=element_this.parentNode.parentNode.parentNode;
	
	var ContestantId=getContestantId(parent_tr);
	var ProblemId=getProblemId(parent_tr);
	
	var markChild=parent_tr.getElementsByClassName('markColumn')[0];
	
	var selectEl=markChild.getElementsByClassName('selectMark')[0];
	var mark=selectEl.options[selectEl.selectedIndex].text;
	
	var commentChild=parent_tr.getElementsByClassName('commentColumn')[0];
	
	var comment=commentChild.getElementsByClassName('modifyComment')[0].innerHTML;
	
	MakeAjaxRequest('../Modify/MakeCorrection.php', {ContestantId:ContestantId, ProblemId:ProblemId, mark:mark, comment:comment});
	
	var changedMark;
	if (markHTML!=mark) {
		changedMark=true;
	}
	markHTML=mark;
	commentHTML=comment;
	Clear(element_this);
	if (changedMark) {
		var userChild=parent_tr.getElementsByClassName('userColumn')[0];
		userChild.innerHTML=SessionUsername;
	}
	
}

function Cancel(element_this) {
	Clear(element_this);
}

function OnModification(element_this) {
	var parent_tr=element_this.parentNode.parentNode.parentNode;
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
	
	markChild.innerHTML=newMarkHTML;
	
	if (commentHTML=='-') commentChild.innerHTML="<div contentEditable='true' class='modifyComment'></div>"
	else commentChild.innerHTML="<div contentEditable='true' class='modifyComment'>"+commentHTML+"</div>"
	
	newConfirmHTML="<div class='confirmButtonContainer buttonContainer'>";
	newConfirmHTML+="<img class='confirmButtonImage buttonImage' src='../View/Images/ConfirmButtonImage.png' alt='Conferma' onclick=Confirm(this)>";
	newConfirmHTML+="</div>";
	confirmChild.innerHTML=newConfirmHTML;
	
	newCancelHTML="<div class='cancelButtonContainer buttonContainer'>";
	newCancelHTML+="<img class='cancelButtonImage buttonImage' src='../View/Images/CancelButtonImage.png' alt='Annulla' onclick=Cancel(this)>";
	newCancelHTML+="</div>";
	cancelChild.innerHTML=newCancelHTML;
	
	var modifyButtons=document.getElementsByClassName("modifyButtonImage");
	for (i=0; i<modifyButtons.length; i++) modifyButtons[i].style["display"]='none';
}
