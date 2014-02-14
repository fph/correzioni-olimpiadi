<?php
global $v_corrections, $v_contestant, $v_contest;
?>

<script>
	function OnModification(elemento) {
		var parent=elemento.parentNode.parentNode;
		var markChild=parent.getElementsByClassName('markColumn')[0];
		var previousMarkHTML=markChild.innerHTML;
		
		var commentChild=parent.getElementsByClassName('commentColumn')[0];
		var previousCommentHTML=commentChild.innerHTML;
		
		var confirmChild=parent.getElementsByClassName('modifyColumn')[0];
		
		var newMarkHTML="<select><option name ='-'>-</option>";
		for (i=0; i<=7; i++) {
			if (i==previousMarkHTML) newMarkHTML+="<option name ='"+i+"' selected='selected'>"+i+"</option>";
			else newMarkHTML+="<option name ='"+i+"'>"+i+"</option>";
			
		}
		newMarkHTML+="</select>";
		
		markChild.innerHTML=newMarkHTML;
		
		commentChild.innerHTML="<textarea class='modifyTextareaComment'>"+previousCommentHTML+"</textarea>"
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
			<td class='modifyColumn'> <div class='modifyButtonContainer' onclick=OnModification(this)>
			<img class='modifyButtonImage' src='../View/Images/ModifyButtonImage.png' alt='Modifica'>
			</div> </td>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<?php
}
?>
