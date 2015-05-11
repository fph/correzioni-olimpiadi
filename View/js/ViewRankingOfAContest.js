function MailSent(response) {
	var MailingRow = document.getElementsByClassName('MailingRow')[0];
	if (response.type == 'good') {
		var MailButtonContainer = MailingRow.getElementsByClassName('MailButtonContainer');
		if (MailButtonContainer.length>0) ChangeMailToRemail(MailButtonContainer[0]);
	}
	MailingRow.classList.remove('MailingRow');
}

function SendMail(row) {
	MakeAjaxRequest('../Modify/MailSender.php', {ContestId: ContestId, ContestantId: GetDataAttribute(row, 'ContestantId')}, MailSent);
	row.classList.add('MailingRow');
}

var RowsWithRemail = document.getElementsByClassName('ContestantWithRemail');
for (var i=0; i<RowsWithRemail.length; i++) {
	var row = RowsWithRemail[i];
	ChangeMailToRemail(row.getElementsByClassName('MailButtonContainer')[0]);
}
