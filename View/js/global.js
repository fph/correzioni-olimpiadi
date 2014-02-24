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


var MonthDaysNumber=[0,31,28,31,30,31,30,31,31,30,31,30,31];
var MonthName=['','gennaio','febbraio','marzo','aprile','maggio','giugno','luglio','agosto','settembre','ottobre','novembre','dicembre'];
function ParseDate(DateString) {
	var parts = DateString.split('-');
	var yearX=parseInt(parts[0]);
	var monthX=parseInt(parts[1]);
	var dayX=parseInt(parts[2]);
	return {day:dayX, month:monthX, year:yearX};
}

//Transform the date in an italian style long date
function GetExtendedItalianDate( DateString ){
	if( DateString == null ) return null;
	var DateObj=ParseDate( DateString );
	return DateObj.day+' '+MonthName[DateObj.month]+' '+DateObj.year;
}

//Transform date in an italian short date
function GetRestrictedItalianDate(date){
	if( DateString == null ) return null;
	var DateObj=ParseDate( DateString );
	return DateObj.day+'/'+DateObj.month+'/'+DateObj.year;
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
