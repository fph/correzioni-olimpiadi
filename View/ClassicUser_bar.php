<a href="UserConfiguration.php" id="UsernameLink"> 
<span id="UsernameInner">
<?php
	session_start();
	echo $_SESSION['username'];
?>
</span>
</a>
<a href="Logout.php" id="logout"> Logout </a>
