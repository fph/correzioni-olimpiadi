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

function AddRow(columns, classes, RedirectUrl, getElements, orderby, buttons, datas){
	var InformationTable=document.getElementsByClassName('InformationTable')[0];
	var EmptyTable=document.getElementsByClassName('EmptyTable')[0];
	if (InformationTable.classList.contains('hidden')) {
		EmptyTable.classList.add('hidden');
		InformationTable.classList.remove('hidden');
	}
	
	var tbodyEl=InformationTable.getElementsByTagName('tbody')[0];
	
	var NewRow=document.createElement('tr');

	NewRow.classList.add('NewRow');
	for (var cl in classes) NewRow.classList.add(classes[cl]);
	setTimeout(function(){ NewRow.classList.remove('NewRow'); },5000);

	SetDataAttribute(NewRow, "orderby", columns[orderby]);
	for (var da in datas) NewRow.setAttribute('data-'+da,datas[da]);
	
	if (RedirectUrl!=null) NewRow.onclick=function(){Redirect(RedirectUrl, getElements)};
	
	var NewRowHTML='';
	for (var co in columns) {
		if (co=='date') NewRowHTML+="<td class='"+co+"_column'>"+GetItalianDate(columns[co])+"</td>";
		else NewRowHTML+="<td class='"+co+"_column'>"+columns[co]+"</td>";
	}
	
	for (var bu in buttons) {
		NewRowHTML+="<td class='"+bu+"_column'> <div class='ButtonContainer'>";
		NewRowHTML+="<img class='"+bu+"_button_image ButtonImage' src='../View/Images/"+bu+"_button_image.png' alt='Elimina' onclick="+buttons[bu]+">";
		NewRowHTML+="</div> </td>";
	}
	
	NewRow.innerHTML=NewRowHTML;
	
	var childs=tbodyEl.getElementsByTagName('tr');
	
	var compareEl=GetDataAttribute(NewRow, "orderby");
	
	var aggiunto=false;
	for (var i=0; i<childs.length; i++) {
		var sortingEl=GetDataAttribute( childs[i], "orderby");
		if (String(compareEl).localeCompare(String(sortingEl))<0) {
			tbodyEl.insertBefore(NewRow,childs[i]);
			aggiunto=true;
			break;
		}
	}
	if (aggiunto==false) tbodyEl.appendChild(NewRow);
	
	
	//~ PARTE PER RIPULIRE L'INPUT FORM DA RIVEDERE
	//~ for (var co in columns) document.getElementById(co+'_input').value='';
}


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

function GetRestrictedItalianDate(date){
	if (date==null) return date;
	dividedDate=date.split("-");
	italianDate=dividedDate[2]+"/"+dividedDate[1]+"/"+dividedDate[0];
	return italianDate;
}

function GetItalianDate(date){
	return GetExtendedItalianDate(date);
}

function SetDataAttribute( DomObject, Attribute, Value ) {
	DomObject.setAttribute('data-'+Attribute, Value);
}

function GetDataAttribute( DomObject, Attribute ) {
	return DomObject.getAttribute('data-'+Attribute);
}

function CFL( str ) {
	return str.charAt(0).toUpperCase()+str.slice(1);
}
