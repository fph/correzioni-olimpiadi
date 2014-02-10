<div id="upperBar">
	<div id="innerBar">
		<a href="UserConfiguration.php" id="username"> 
		<?php
			session_start();
			echo $_SESSION['username'];
		?>
		
		</a>
		<a href="Logout.php" id="logout"> Logout </a>
	</div>
</div>
