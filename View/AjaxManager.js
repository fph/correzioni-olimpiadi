function ManageAjaxRequest() {
	if ( ajaxReq.readyState==4 && ajaxReq.status==200) {
		var text=ajaxReq.responseText; //Magari usare json!
	}
}

function MakeAjaxRequest( $url, $data ) {
	var ajaxReq;
	if (window.XMLHttpRequest)ajaxReq = new XMLHttpRequest();
	else ajaxReq = new ActiveXObject("Microsoft.XMLHTTP");
	ajaxReq.open("POST", url, true);
	ajaxReq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	var PostData='';
	var first=0;
	for ( var key in $data ) {
		if ( first==1 ) PostData+='&';
		PostData+=key+'='+data[key]; //da fare l'escape!
		first=1;
	}
	ajaxReq.send( PostData );
	ajaxReq.onreadystatechange = showMessage;
}
