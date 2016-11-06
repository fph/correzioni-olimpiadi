function MailSent(response) {
	var MailingRow = document.getElementsByClassName('MailingRow')[0];
	if (response.type == 'good') {
		var ButtonsContainer = MailingRow.getElementsByClassName('ButtonsContainer')[0];
		ChangeMailToRemail(ButtonsContainer);
	}
	MailingRow.classList.remove('MailingRow');
}

function SendGoodMail(row) {
	MakeAjaxRequest('../Modify/ReportSender.php', {ContestId: ContestId, ContestantId: GetDataAttribute(row, 'ContestantId'), accepted: true}, MailSent);
	row.classList.add('MailingRow');
}

function SendBadMail(row) {
	MakeAjaxRequest('../Modify/ReportSender.php', {ContestId: ContestId, ContestantId: GetDataAttribute(row, 'ContestantId'), accepted: false}, MailSent);
	row.classList.add('MailingRow');
}

var RowsWithRemail = document.getElementsByClassName('ContestantWithRemail');
for (var i = 0; i < RowsWithRemail.length; i++) {
	var row = RowsWithRemail[i];
	ChangeMailToRemail(row.getElementsByClassName('ButtonsContainer')[0]);
}
