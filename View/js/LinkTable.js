function RenderLinkTable(obj) {
	var table = document.createElement('table');
	table.classList.add('LinkTable');
	var tbody = document.createElement('tbody');
	for (var i = 0; i < obj.length; i++) {
		var tr = document.createElement('tr');
		var td = document.createElement('td');
		var a = document.createElement('a');
		a.innerHTML = obj[i].name;
		a.href = CreateUrl(obj[i].redirect.url, obj[i].redirect.parameters);
		
		td.appendChild(a);
		tr.appendChild(td);
		tbody.appendChild(tr);
	}
	table.appendChild(tbody);
	return table;
}

//The variable LinkTablesInformation is defined server-side
if (LinkTablesInformation != null) {
	for (var i=0; i<LinkTablesInformation.length; i++) {
		var LinkTable = LinkTablesInformation[i];
		var DivToLinkTable = document.getElementById('DivToLinkTable'+i);
		DivToLinkTable.parentNode.replaceChild(RenderLinkTable(LinkTable), DivToLinkTable);
	}
}
