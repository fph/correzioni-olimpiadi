function MakeAjaxRequest( url, data , exec , NoMessage) {
	var ajaxReq;
	if (window.XMLHttpRequest)ajaxReq = new XMLHttpRequest();
	else ajaxReq = new ActiveXObject("Microsoft.XMLHTTP");
	ajaxReq.open("POST", url, true);
	ajaxReq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajaxReq.send( 'data='+encodeURIComponent( JSON.stringify( data ) ) );
	ajaxReq.onreadystatechange = function() {
		if ( ajaxReq.readyState==4 && ajaxReq.status==200) {
			var response=JSON.parse( ajaxReq.responseText ); //Magari usare json!
			if( NoMessage == null || NoMessage!=1 )ShowMessage(response.type, response.text);
			if (exec) exec( response );
		}
	};
}
