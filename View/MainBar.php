<div id="MainBar_container">
	<div id="MainBar_floater">
		<div id="MainBar_inner">
			<h1 id="MainBar_title"> Olimpiadi di Matematica - Correzioni</h1>
			
			<div id="MainBar_UserList">
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
</div>
