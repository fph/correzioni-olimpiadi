<div id="MainBar_container">
	<div id="MainBar_floater">
		<div id="MainBar_inner">
			<a href="AccountSettings.php" id="UsernameLink"> 
				<span id="UsernameInner">
					<?php
						session_start();
						echo $_SESSION['username'];
					?>
				</span>
			</a>
			<a href="Logout.php" id="logout"> Logout </a>
		</div>
	</div>
</div>
