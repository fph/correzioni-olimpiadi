function ShowMessage( type , text ) {
	var Message=document.createElement('div');
	Message.className=type+'_Message';
	Message.innerHTML=text;
	document.getElementById('MessageList').appendChild(Message);
	if( type=='good' ) setTimeout(function(){ document.getElementById('MessageList').removeChild(Message); },3000);
	if( type=='bad'  ) setTimeout(function(){ document.getElementById('MessageList').removeChild(Message); },5000);
}
