//Takes url and Get Parameters (as an object) and redirect the page as requested
function Redirect(pageUrl, getElements) {
	var url=pageUrl+'.php';
	if (getElements!=null) {
		var i=0;
		for (var el in getElements) {
			if (i==0) url+='?';
			else url+='&';
			i++;
			url+=el+'='+getElements[el];
		}
	}
	document.location=url;
}

//Transform the date in an italian style long date
function GetExtendedItalianDate(date){
	if (date==null) return date;
	dividedDate=date.split("-");
	italianDate=dividedDate[2]+" ";
	
	month=dividedDate[1];
	if (month=='01') italianDate+="gennaio";
	if (month=='02') italianDate+="febbraio";
	if (month=='03') italianDate+="marzo";
	if (month=='04') italianDate+="aprile";
	if (month=='05') italianDate+="maggio";
	if (month=='06') italianDate+="giugno";
	if (month=='07') italianDate+="luglio";
	if (month=='08') italianDate+="agosto";
	if (month=='09') italianDate+="settembre";
	if (month=='10') italianDate+="ottobre";
	if (month=='11') italianDate+="novembre";
	if (month=='12') italianDate+="dicembre";
	italianDate+=" "+dividedDate[0];
	return italianDate;
}

//Transform date in an italian short date
function GetRestrictedItalianDate(date){
	if (date==null) return date;
	dividedDate=date.split("-");
	italianDate=dividedDate[2]+"/"+dividedDate[1]+"/"+dividedDate[0];
	return italianDate;
}


//Wrapper for one of the two function
function GetItalianDate(date){
	return GetExtendedItalianDate(date);
}

//Simple functions written for compatibility with ie10 (which doesn't implement dataList)
function SetDataAttribute( DomObject, Attribute, Value ) {
	DomObject.setAttribute('data-'+Attribute, Value);
}

function GetDataAttribute( DomObject, Attribute ) {
	return DomObject.getAttribute('data-'+Attribute);
}

//CapitaliseFirstLetter
function CFL( str ) {
	return str.charAt(0).toUpperCase()+str.slice(1);
}
