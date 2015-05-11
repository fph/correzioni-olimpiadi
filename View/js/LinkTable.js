function RenderLinkTable(obj) {
	var table = document.createElement('table');
	table.classList.add('LinkTable');
	var tbody = document.createElement('tbody');
	for (var i=0; i<obj.length; i++) {
		var tr = document.createElement('tr');
		var td = document.createElement('td');
		var span = document.createElement('span');
		span.innerHTML=obj[i].name;
		SetDataAttribute(span, 'redirect', JSON.stringify(obj[i].redirect));
		span.classList.add('CursorPointer');
		
		
		span.addEventListener('click', function(e) {
			var DataRedirect = JSON.parse(GetDataAttribute(this, 'redirect'));
			Redirect(DataRedirect.url, DataRedirect.parameters);
		});
		
		td.appendChild(span);
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
