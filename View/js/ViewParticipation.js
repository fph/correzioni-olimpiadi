function ChangeMailColor(response) {
	if (response.type == 'good') {
		var subtitle = document.getElementsByClassName('PageSubtitle')[0];
		var ButtonsContainer = subtitle.getElementsByClassName('ButtonsContainer')[0];
		ChangeMailToRemail(ButtonsContainer);
	}
}

function SendGoodMail(ContestId, ContestantId) {
	MakeAjaxRequest('../Modify/ReportSender.php', {ContestId: ContestId, ContestantId: ContestantId, accepted: true}, ChangeMailColor);
}

function SendBadMail(ContestId, ContestantId) {
	MakeAjaxRequest('../Modify/ReportSender.php', {ContestId: ContestId, ContestantId: ContestantId, accepted: false}, ChangeMailColor);
}
