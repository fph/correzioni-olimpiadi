<?php
global $v_corrections, $v_contestant, $v_contest;
?>

<script>
	var previousMarkHTML;
	var previousCommentHTML;
	
	function Clear(element_this) {
		var parent_tr=element_this.parentNode.parentNode.parentNode;
		var markChild=parent_tr.getElementsByClassName('markColumn')[0];
		markChild.innerHTML=previousMarkHTML;
		
		var commentChild=parent_tr.getElementsByClassName('commentColumn')[0];
		commentChild.innerHTML=previousCommentHTML;
		
		var modifyButtons=document.getElementsByClassName("modifyButtonImage");
		for (i=0; i<modifyButtons.length; i++) modifyButtons[i].style.display='initial';
		
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
		
		var ContestantId=document.getElementsByClassName('pageSubtitle')[0].id;
		
		var ProblemId=parent_tr.getElementsByClassName('problemColumn')[0].id;
		
		var markChild=parent_tr.getElementsByClassName('markColumn')[0];
		
		var selectEl=markChild.getElementsByClassName('selectMark')[0];
		var mark=selectEl.options[selectEl.selectedIndex].text;
		
		var commentChild=parent_tr.getElementsByClassName('commentColumn')[0];
		
		var comment=commentChild.getElementsByClassName('modifyComment')[0].innerHTML;
		
		MakeAjaxRequest('../Modify/MakeCorrection.php', {ContestantId:ContestantId, ProblemId:ProblemId, mark:mark, comment:comment});
		
		var changedMark;
		if (previousMarkHTML!=mark) {
			changedMark=true;
		}
		previousMarkHTML=mark;
		previousCommentHTML=comment;
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
		previousMarkHTML=markChild.innerHTML;
		
		var commentChild=parent_tr.getElementsByClassName('commentColumn')[0];
		previousCommentHTML=commentChild.innerHTML;
		
		var confirmChild=parent_tr.getElementsByClassName('modifyColumn')[0];
		
		var cancelChild=parent_tr.getElementsByClassName('cancelColumn')[0];
		
		var newMarkHTML="<select class='selectMark'><option name ='-'>-</option>";
		for (i=0; i<=7; i++) {
			if (i==previousMarkHTML) newMarkHTML+="<option name ='"+i+"' selected='selected'>"+i+"</option>";
			else newMarkHTML+="<option name ='"+i+"'>"+i+"</option>";
			
		}
		newMarkHTML+="</select>";
		
		markChild.innerHTML=newMarkHTML;
		
		if (previousCommentHTML=='-') commentChild.innerHTML="<div contentEditable='true' class='modifyComment'></div>"
		else commentChild.innerHTML="<div contentEditable='true' class='modifyComment'>"+previousCommentHTML+"</div>"
		
		newConfirmHTML="<div class='confirmButtonContainer buttonContainer'>";
		newConfirmHTML+="<img class='confirmButtonImage buttonImage' src='../View/Images/ConfirmButtonImage.png' alt='Conferma' onclick=Confirm(this)>";
		newConfirmHTML+="</div>";
		confirmChild.innerHTML=newConfirmHTML;
		
		newCancelHTML="<div class='cancelButtonContainer buttonContainer'>";
		newCancelHTML+="<img class='cancelButtonImage buttonImage' src='../View/Images/CancelButtonImage.png' alt='Annulla' onclick=Cancel(this)>";
		newCancelHTML+="</div>";
		cancelChild.innerHTML=newCancelHTML;
		
		var modifyButtons=document.getElementsByClassName("modifyButtonImage");
		for (i=0; i<modifyButtons.length; i++) modifyButtons[i].style.display='none';
	}
</script>


<h2 class="pageTitle">
<?=$v_contest['name']?>
</h2>

<h3 class="pageSubtitle" id="<?=$v_contestant['id']?>">
<?=$v_contestant['surname']?> <?=$v_contestant['name']?>
</h3>

<?php
if (empty($v_corrections)) {
	?>
	<div class='emptyTable'> Ancora nessuna correzione. </div>
	<?php
}
else {
?>

<table class="InformationTable" id="participationTable">
	<thead><tr>
		<th class='problemColumn'>Problema</th>
		<th class='markColumn'>Voto</th>
		<th class='commentColumn'>Commento</th>
		<th class='userColumn'>Correttore</th>
		<th class='modifyColumn'></th>
		<th class='cancelColumn'></th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_corrections as $cor) {
		?>
			<tr id='Participation<?=$cor['problem']['id']?>'><td class='problemColumn' id='<?=$cor['problem']['id']?>'><?=$cor['problem']['name']?></td>
			
			<?php
			if ($cor["done"]) {
				?>
				<td class='markColumn'><?=$cor['mark']?></td>
				<td class='commentColumn'><?=$cor['comment']?></td>
				<td class='userColumn'><?=$cor['username']?></td>
				<?php
			}
			else {
				?>
				<td class='markColumn'>-</td><td class='commentColumn'>-</td><td class='userColumn'>-</td>
				<?php
			}
			?>
			<td class='modifyColumn'> <div class='modifyButtonContainer buttonContainer'>
			<img class='modifyButtonImage buttonImage' src='../View/Images/ModifyButtonImage.png' alt='Modifica' onclick=OnModification(this)>
			</div> </td>
			<td class='cancelColumn'> <div class='cancelButtonContainer buttonContainer'> </div> </td>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<?php
}
?>
