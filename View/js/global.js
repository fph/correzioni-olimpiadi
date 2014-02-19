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

function AddRow(columns, classes, RedirectUrl, getElements, orderBy){
	var emptyTable=document.getElementsByClassName('emptyTable')[0];
	if (emptyTable!=null) {
		emptyTable.parentNode.removeChild(emptyTable);
		var InformationTable=document.getElementsByClassName('InformationTable')[0];
		InformationTable.setAttribute('class','InformationTable');
	}
	
	var InformationTable=document.getElementsByClassName('InformationTable')[0];
	var tbodyEl=InformationTable.getElementsByTagName('tbody')[0];
	
	var newRow=document.createElement('tr');
	
	newRow.className='new_row';
	for (var cl in classes) newRow.className+=' '+classes[cl];
	setTimeout(function(){ newRow.classList.remove('new_row'); },5000);

	newRow.setAttribute('value',columns[orderBy]);
	
	newRow.onclick=function(){Redirect(RedirectUrl, getElements)};
	
	var newRowHTML='';
	for (var co in columns) {
		if (co=='date') newRowHTML+="<td class='"+co+"Column'>"+getItalianDate(columns[co])+"</td>";
		else newRowHTML+="<td class='"+co+"Column'>"+columns[co]+"</td>";
	}
	newRow.innerHTML=newRowHTML;
	
	var childs=tbodyEl.getElementsByTagName('tr');
	
	var compareEl=newRow.getAttribute('value');
	
	var aggiunto=false;
	for (var i=0; i<childs.length; i++) {
		var sortingEl=childs[i].getAttribute('value');
		if (String(compareEl).localeCompare(String(sortingEl))<0) {
			tbodyEl.insertBefore(newRow,childs[i]);
			aggiunto=true;
			break;
		}
	}
	if (aggiunto==false) tbodyEl.appendChild(newRow);
	
	//~ for (var co in columns) document.getElementById(co+'_input').value='';
}


function getExtendedItalianDate(date){
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

function getRestrictedItalianDate(date){
	if (date==null) return date;
	dividedDate=date.split("-");
	italianDate=dividedDate[2]+"/"+dividedDate[1]+"/"+dividedDate[0];
	return italianDate;
}

function getItalianDate(date){
	return getExtendedItalianDate(date);
}
