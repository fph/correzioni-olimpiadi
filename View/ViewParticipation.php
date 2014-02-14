<?php
global $v_corrections, $v_contestant, $v_contest;
?>

<script>
	
	function Confirm(element_this){
		
	}
	
	function OnModification(element_this) {
		var parent_tr=element_this.parentNode.parentNode.parentNode;
		var markChild=parent_tr.getElementsByClassName('markColumn')[0];
		var previousMarkHTML=markChild.innerHTML;
		
		var commentChild=parent_tr.getElementsByClassName('commentColumn')[0];
		var previousCommentHTML=commentChild.innerHTML;
		
		var confirmChild=parent_tr.getElementsByClassName('modifyColumn')[0];
		
		var newMarkHTML="<select><option name ='-'>-</option>";
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
		
		var modifyButtons=document.getElementsByClassName("modifyButtonImage");
		for (i=0; i<modifyButtons.length; i++) modifyButtons[i].style.display='none';
	}
</script>


<h2 class="pageTitle">
<?=$v_contest['name']?>
</h2>

<h3 class="pageSubtitle">
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
			<tr id='Participation<?=$cor['problem']['id']?>'><td class='problemColumn'><?=$cor['problem']['name']?></td>
			
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
