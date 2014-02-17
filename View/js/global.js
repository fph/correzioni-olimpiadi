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
	var InformationTable=document.getElementsByClassName('InformationTable')[0];
	var tbodyEl=InformationTable.getElementsByTagName('tbody')[0];
	
	var newRow=document.createElement('tr');
	
	newRow.className='new_row';
	for (var cl in classes) newRow.className+=' '+classes[cl];
	setTimeout(function(){ newRow.classList.remove('new_row'); },5000);
	
	newRow.onclick=function(){Redirect(RedirectUrl, getElements)};
	
	var newRowHTML='';
	for (var co in columns) newRowHTML+="<td class='"+co+"Column'>"+columns[co]+"</td>";
	newRow.innerHTML=newRowHTML;
	
	var childs=tbodyEl.getElementsByTagName('tr');
	
	var compareEl;
	for (var co in columns) if (co==orderBy) compareEl=columns[co];
	
	var aggiunto=false;
	for (var i=0; i<childs.length; i++) {
		var sortingColumn=childs[i].getElementsByClassName(orderBy+'Column')[0];
		if (String(compareEl).localeCompare(String(sortingColumn.innerHTML))<0) {
			tbodyEl.insertBefore(newRow,childs[i]);
			aggiunto=true;
			break;
		}
	}
	if (aggiunto==false) tbodyEl.appendChild(newRow);
	
	for (var co in columns) document.getElementById(co+'_input').value='';
}
