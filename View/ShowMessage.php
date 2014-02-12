<?php
global $v_Message; 
?>
<div class="ShowMessage" id="ShowMessage_<?php echo $v_Message['type']; ?>"> 
	<span id="ShowMessage_span">
		<?php echo $v_Message['text']; ?>
	</span>
</div>
