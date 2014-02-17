<h2 class='pageTitle'> Configurazione account</h2>
<div id='UsernameChange_container' class='formContainer'>
	<h3 class='pageSubtitle'> Cambio Username </h3>
	<form action="AccountSettings.php" method="POST" id="UsernameChange">
		<input type='hidden' name='type' value='ChangeUsername'>
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
</div>

<div id='PasswordChange_container' class='formContainer'>
	<h3 class='pageSubtitle'> Cambio Password </h3>
	<form action="AccountSettings.php" method="POST" name="PasswordChange">
		<input type='hidden' name='type' value='ChangePassword'>
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
</div>
