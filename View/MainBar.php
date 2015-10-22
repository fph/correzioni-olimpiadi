<?php
	global $MainBarUserId, $MainBarUsername, $v_content;
?>
<div id='MainBar_container'>
	<div id='MainBar_floater'>
		<div id='MainBar_inner'>
			<a href='<?=($v_content !== 'ParticipationRequest')?'index.php':'ParticipationRequest.php'?>'> <h1 id='MainBar_title'> Olimpiadi di Matematica - Correzioni </h1> </a>
			
			<?php
				if ($MainBarUserId != -1) {
			?>
			<div id='MainBar_UserList'>
				<a href='AccountSettings.php' id='UsernameLink'> 
					<span id='UsernameInner'>
						<?=$MainBarUsername?>
					</span>
				</a>
				<a href='Logout.php' id='logout'> Logout </a>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
