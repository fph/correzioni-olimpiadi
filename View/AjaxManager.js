function showMessage( type , text ) {
	alert(type+': '+text);
}

function MakeAjaxRequest( url, data ) {
	var ajaxReq;
	if (window.XMLHttpRequest)ajaxReq = new XMLHttpRequest();
	else ajaxReq = new ActiveXObject("Microsoft.XMLHTTP");
	ajaxReq.open("POST", url, true);
	ajaxReq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	
	ajaxReq.send( 'data='+JSON.stringify( data ) );
	ajaxReq.onreadystatechange = function() {
		if ( ajaxReq.readyState==4 && ajaxReq.status==200) {
			var msg=JSON.parse( ajaxReq.responseText ); //Magari usare json!
			showMessage(msg.type, msg.text);
		}
	};
}
