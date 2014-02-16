function AddRow(){
	
}


function AddContestant(response){
	if (response.type=='good') {
		var tbodyElement=document.getElementsByClassName('InformationTableTbody')[0];
		var surname=document.getElementById('inputSurname').value;
		var name=document.getElementById('inputName').value;
		
		//~ AddRow('ContestantsTobdy',{surname:surname, name:name});
		
		var newRow="<tr class='trlink' onclick=Redirect("+response.ContestantId+")>";
		newRow+="<td class='surnameColumn'>"+surname+"</td>";
		newRow+="<td class='nameColumn'>"+name+"</td></tr>";
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
