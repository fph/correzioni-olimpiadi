<h1 class='PageTitle'> Configurazione account</h1>
<h2 class='PageSubTitle'> <?php session_start(); echo $_SESSION['username']; ?> </h2>
<form action="" method="POST" name="UsernameChange">
<input type="text" name="NewUsername" value="NuovoUsername"> 
<input type="submit" value="Salva"> 
</form>
<form action="" method="POST" name="PasswordChange">
<input type="text" name="OldPassword" value="Vecchia Password">
<input type="text" name="NewPassword" value="Nuova Password"> 
<input type="submit" value="Salva"> 
</form>
