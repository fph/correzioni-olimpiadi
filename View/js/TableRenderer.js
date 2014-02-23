function RenderTable( obj ) {
	var table=document.createElement('table');
	table.classList.add('InformationTable');
	var redirecting=obj.redirect.presence;
	var url=obj.redirect.url;
	var buttoning=obj.buttons.presence;
	var ButtonsTd;
	if( buttoning == 1 ){
		//Creo ButtonsTd
	}
	if( obj.class != null ) {
		for( var i=0; i<obj.class.length; i++ ) table.classList.add( obj.class[i] );
	}
	if( obj.id != null ) table.id=obj.id;
	
	if( obj.data != null ) {
		// Qui devo piazzare i data della tabella
	}
	var TableHeader=document.createElement('thead');
	var TableHeaderTr=document.createElement('tr');
	for( var i=0;i<obj.columns.length;i++) {
		var th=document.createElement('th');
		var column=obj.columns[i];
		if( column.class != null ) {
			for( var j=0; j<column.class.length; j++ ) th.classList.add( column.class[j] );
		}
		if( column.order == 1 ) {
			//Qui dovrei implementare il fatto che si possa ordinare in base a questa riga...
		}
		th.innerHTML=column.name;
		TableHeaderTr.appendChild(th);
	}
	if( buttoning ) {
		var ButtonContainerTh=document.createElement('th');
		//Qua dovrei metterci tutte le classi del caso...
		TableHeaderTr.appendChild( ButtonContainerTh );
	}
	TableHeader.appendChild(TableHeaderTr);
	table.appendChild(TableHeader);
	
	var tbody=document.createElement('tbody');
	for(var i=0;i<obj.rows.length;i++) {
		var row=obj.rows[i];
		var tr=document.createElement('tr');
		if( redirecting==1 ) {
			SetDataAttribute(tr, 'redirect_url', url);
			SetDataAttribute(tr, 'redirect_obj', JSON.stringify( row.redirect ) );
			tr.addEventListener('click', function(e){ 
				Redirect( GetDataAttribute(this,'redirect_url'), JSON.parse(GetDataAttribute(this,'redirect_obj')) ); 
			} );
			tr.classList.add('trlink');
		}
		if( row.class != null ) {
			for(var j=0;j<row.class.length;j++) tr.classList.add(row.class[j]);
		}
		
		//Qui dovrei mettere tutti i data del caso
		
		for(var j=0;j<obj.columns.length;j++) {
			var column=obj.columns[j];
			var td=document.createElement('td');
			if( column.class != null ) {
				for( var k=0; k<column.class.length; k++ ) td.classList.add( column.class[k] );
			}
			td.innerHTML=row[column.id];
			tr.appendChild(td);
		}
		if( buttoning==1 ) {
			tr.appendChild(ButtonsTd);
		}
		tbody.appendChild(tr);
	}
	table.appendChild(tbody);
	return table;
}

var DivToTable=document.getElementsByClassName('DivToTable');
for(var i=0;i<DivToTable.length;i++) {
	//~ alert(DivToTable[i].innerHTML);
	var table=JSON.parse(DivToTable[i].innerHTML);
	DivToTable[i].parentNode.replaceChild( RenderTable(table), DivToTable[i]);
}
