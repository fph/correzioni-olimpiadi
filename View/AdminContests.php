<?php
global $v_contests;
?>

<h2 class='PageTitle'>
	Gare
</h2>

<h3 class='PageSubtitle'>
	Lista delle gare
</h3>

<?php
if (empty($v_contests)) {
	?>
	<div class='EmptyTable'> Ancora nessuna gara inserita. </div>
	<table class='InformationTable hidden'>
	<?php
}
else {
?>
	<div class='EmptyTable hidden'> Ancora nessuna gara inserita. </div>
	<table class='InformationTable'>
	<?php
}?>
	<thead><tr>
		<th class='ContestColumn'>Gara</th>
		<th class='DateColumn'>Data</th>
	</tr></thead>
	
	<tbody>
	<?php
		foreach($v_contests as $con) {
			?>
			<tr class='trlink'
			<?php if (!is_null($con['date']) ) {
				?>
				data-orderby='<?=$con['date']?>'
				<?php
			}
			else {
				?>
				data-orderby='0000-00-00'
				<?php
			}?>
			onclick="Redirect('AdminContestInformation',{ContestId:<?=$con['id']?>})">
			<td class='ContestColumn'><?=$con['name']?>
			<span class='blocked CorrectionsCompleted' >
			<?php
			if ($con['blocked']==1) {
				?>
				Correzioni terminate
				<?php
			}?>
			</span>
			</td>			
			<?php if (!is_null($con['date'])) { 
				?> 
				<td class='DateColumn'><?=GetItalianDate($con['date'])?></td> 
				<?php 
			}
			else { 
				?>
				<td class='DateColumn'>-</td> 
				<?php 
			} ?>
			</tr>
			<?php
		}
	?>
	</tbody>
	
</table>

<h3 class="PageSubtitle">
	Aggiungi una gara
</h3>

<div class='createContainer'>
	<table>
	<tr>
		<th> Nome </th>
		<th> Data </th>
		<th> </th>
	</tr>
	<tr>
		<td> <input type="text" name="name" id="name_input"> </td>
		<td> 
			<?php include 'DateInput.html' ?>
		</td>
		<td> <input type="button" value="Aggiungi" onclick=AddContestRequest()> </td>
	</tr>
	</table>
</div>
