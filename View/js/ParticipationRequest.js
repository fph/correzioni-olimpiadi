function CodeSent(response) {
	if (response.type == 'good') {
		var email = response.data['email'];
		document.getElementById('CheckCodeForm').elements.namedItem('email').value = email;
	}
}

function SendCode(inputs) {
	var email = inputs.namedItem('email').value;
	MakeAjaxRequest('../Modify/ManageVerificationCode.php', {email: email, type: 'send'}, CodeSent);
}

function CheckCode(inputs) {
	var email = inputs.namedItem('email').value;
	var code = inputs.namedItem('code').value;
	MakeAjaxRequest('../Modify/ManageVerificationCode.php', {email: email, code: code, type: 'check'});
}
