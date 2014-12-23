function ShowMessage( type , text ) {
	var message=document.createElement('div');
	message.className=CFL(type)+'Message';
	message.innerHTML=text;
	document.getElementById('MessageList').appendChild(message);
	if( type=='good' ) setTimeout(function(){ document.getElementById('MessageList').removeChild(message); },3000);
	if( type=='bad'  ) setTimeout(function(){ document.getElementById('MessageList').removeChild(message); },5000);
}
