<div id='MainBar_container'>
	<div id='MainBar_floater'>
		<div id='MainBar_inner'>
			<a href='index.php'> <h1 id='MainBar_title'> Olimpiadi di Matematica - Correzioni </h1> </a>
			
			<?php
				global $MainBarUserId, $MainBarUsername;
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
