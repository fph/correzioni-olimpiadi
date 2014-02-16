function AddRow(columns, classes, RedirectUrl, getElements, orderBy){
	var InformationTable=document.getElementsByClassName('InformationTable')[0];
	var tbody=InformationTable.getElementsByTagName('tbody')[0];
	
	var newRow=document.createElement('tr');
	
	newRow.className='';
	for (var cl in classes) newRow.className+=' '+classes[cl];
	
	newRow.onclick=function(){Redirect(RedirectUrl, getElements)};
	
	var newRowHTML='';
	for (var co in columns) newRowHTML+="<td class='"+co+"Column'>"+columns[co]+"</td>";
	newRow.innerHTML=newRowHTML;
	
	var childs=tbody.getElementsByTagName('tr');
	
	var compareEl;
	for (var co in columns) if (co==orderBy) compareEl=columns[co];
	
	var aggiunto=false;
	for (var i=0; i<childs.length; i++) {
		var sortingColumn=childs[i].getElementsByClassName(orderBy+'Column')[0];
		if (String(compareEl).localeCompare(String(sortingColumn.innerHTML))<0) {
			alert(String(sortingColumn.innerHTML));
			tbody.insertBefore(newRow,childs[i]); //DEBUG
			aggiunto=true;
			break;
		}
	}
	if (aggiunto==false) tbody.appendChild(newRow);
	
	tbody.appendChild(newRow);
}


function AddContestant(response){
	if (response.type=='good') {
		var tbodyElement=document.getElementsByClassName('InformationTableTbody')[0];
		var surname=document.getElementById('inputSurname').value;
		var name=document.getElementById('inputName').value;
		
		AddRow({surname:surname, name:name},{0:'trlink'},'AdminContestantInformation', {'contestantId':response.ContestantId});
		
		//~ var newRow="<tr class='trlink' onclick=Redirect("+response.ContestantId+")>";
		//~ newRow+="<td class='surnameColumn'>"+surname+"</td>";
		//~ newRow+="<td class='nameColumn'>"+name+"</td></tr>";
		var tbodyElement=document.getElementById('ContestantsTbody');
		var child=tbodyElement.getElementsByTagName('tr');
		
		var newRow=document.createElement('tr');
		newRow.className='trlink';
		newRow.onclick='Redirect(response.ContestantId)';
		var newRowHTML="<td class='surnameColumn'>"+surname+"</td>";
		newRowHTML+="<td class='nameColumn'>"+name+"</td>";
		newRow.innerHTML=newRowHTML;
		
		var aggiunto=false;
		for (var i=0; i<child.length; i++) {
			surnameColumn=child[i].getElementsByClassName('surnameColumn')[0];
			if (String(surname).localeCompare(String(surnameColumn.innerHTML))<0) {
				tbodyElement.insertBefore(newRow,child[i]);
				aggiunto=true;
				break;
			}
		}
		if (aggiunto==false) tbodyElement.appendChild(newRow);
	}
	document.getElementById('inputSurname').value='';
	document.getElementById('inputName').value='';
}

function AddContestantRequest() {
	var surname=document.getElementById('inputSurname').value;
	var name=document.getElementById('inputName').value;
	MakeAjaxRequest('../Modify/ManageContestant.php', {surname:surname, name:name, type:'add'}, AddContestant);
}
