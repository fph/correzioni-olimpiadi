function MakeAjaxRequest( url, data , exec , NoMessage) {
	var ajaxReq;
	if (window.XMLHttpRequest)ajaxReq = new XMLHttpRequest();
	else ajaxReq = new ActiveXObject('Microsoft.XMLHTTP');
	ajaxReq.open('POST', url, true);
	ajaxReq.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	ajaxReq.send( 'data='+encodeURIComponent( JSON.stringify( data ) ) );
	document.getElementsByTagName('html')[0].classList.add('CursorWait');
	ajaxReq.onreadystatechange = function() {
		if ( ajaxReq.readyState==4 && ajaxReq.status==200) {
			document.getElementsByTagName('html')[0].classList.remove('CursorWait');
			var response=JSON.parse( ajaxReq.responseText ); 
			if( NoMessage == null || NoMessage!=1 )ShowMessage(response.type, response.text);
			if (exec) exec( response );
		}
	};
}
