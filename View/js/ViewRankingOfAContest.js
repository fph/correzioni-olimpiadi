function SendMailContestant(row) {
	SendMail(ContestId, GetDataAttribute(row, 'ContestantId') );
}
