<div class="ContainerBar" id="ClassicUser_ContainerBar">
	<div class="innerBar">
		<a href="UserConfiguration.php" id="username"> 
		<?php
			session_start();
			echo $_SESSION['username'];
		?>
		
		</a>
		<a href="Logout.php" id="logout"> Logout </a>
	</div>
</div>
