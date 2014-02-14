<h1 class='PageTitle'> Configurazione account</h1>
<h2 class='PageSubTitle'> <?php session_start(); echo $_SESSION['username']; ?> </h2>
<form action="AccountSettings.php" method="POST" id="UsernameChange">
	<table>
	<tr>
		<th> Nuovo username </th>
		<th> </th>
	</tr>
	<tr>
		<td>
			<input type="text" name="NewUsername"> 
		</td>
		<td>
			<input type="submit" value="Salva"> 
		</td>
	</tr>
	</table>
</form>

<form action="AccountSettings.php" method="POST" name="PasswordChange">
	<table>
		<tr>
			<th> Vecchia Password </th>
			<th> Nuova Password</th>
			<th> </th>
		</tr>
		<tr>
			<td>
				<input type="password" name="OldPassword" >
			</td>
			<td>
				<input type="password" name="NewPassword" > 
			</td>
			<td>
				<input type="submit" value="Salva"> 
			</td>
		</tr>
	</table>
</form>
