function SendMail(ContestId, ContestantId) {
	MakeAjaxRequest('../Modify/MailSender.php', {ContestId:ContestId, ContestantId:ContestantId})
}
