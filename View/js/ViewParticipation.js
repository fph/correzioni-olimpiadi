function ChangeMailColor(response) {
	if( response.type=='good' ) {
		var MailButtonContainers=document.getElementsByClassName('MailButtonContainer');
		if( MailButtonContainers.length>0 ) ChangeMailToRemail(MailButtonContainers[0]);
	}
}

function SendMail(ContestId, ContestantId) {
	MakeAjaxRequest('../Modify/MailSender.php', {ContestId:ContestId, ContestantId:ContestantId}, ChangeMailColor);
}
