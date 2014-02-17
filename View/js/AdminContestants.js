function AddRow(columns, classes, RedirectUrl, getElements, orderBy){
	var InformationTable=document.getElementsByClassName('InformationTable')[0];
	var tbodyEl=InformationTable.getElementsByTagName('tbody')[0];
	
	var newRow=document.createElement('tr');
	
	newRow.className='';
	for (var cl in classes) newRow.className+=' '+classes[cl];
	
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

	//~ DEBUG
	//~ 
	//~ for (var co in columns) document.getElementById(columns[co]+'_input').value='';
}


function AddContestant(response){
	if (response.type=='good') {
		var tbodyEl=document.getElementsByClassName('InformationTableTbody')[0];
		var surname=document.getElementById('surname_input').value;
		var name=document.getElementById('name_input').value;
		
		AddRow({surname:surname, name:name},{0:'trlink'},'AdminContestantInformation', {'contestantId':response.ContestantId}, 'surname');
	}
}

function AddContestantRequest() {
	var surname=document.getElementById('surname_input').value;
	var name=document.getElementById('name_input').value;
	MakeAjaxRequest('../Modify/ManageContestant.php', {surname:surname, name:name, type:'add'}, AddContestant);
}
