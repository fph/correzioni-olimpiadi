function RenderTable( obj ) {
	var table=document.createElement('table');
	table.classList.add('InformationTable');
	var redirecting=obj.redirect.presence;
	var url=obj.redirect.url;
	var buttoning=obj.buttons.presence;
	var ButtonsTd;
	if( buttoning == 1 ){
		var ItalianTranslation={modify:'Modifica', trash:'Elimina', confirm:'Conferma', cancel:'Annulla'};
		ButtonsTd=document.createElement('td');
		ButtonsTd.id='ButtonsTd';
		for(var i=0; i<obj.buttons.images.length; i++) {
			var button=obj.buttons.images[i];
			var name=button.name;
			SetDataAttribute(table,name+'_function',button.onclick);
			image=document.createElement('img');
			image.setAttribute('src','../View/Images/'+name+'_button_image.jpg');
			image.setAttribute('alt',ItalianTranslation(name));
			image.setAttribute('title',ItalianTranslation(name));
			SetDataAttribute(image,'name',name);
			image.classList.add('ButtonImage');
			image.classList.add(name+'_button_image');
			if( button.hidden == 1 ) image.classList.add('hidden');
			image.addEventListener('click',function(e) {
				var ParentTable=this.parentNode.parentNode.parentNode.parentNode;
				eval( getDataAttribute(ParentTable, getDataAttribute(this,'name')+'_function')+'(this);' );
			} );
			ButtonsTd.appendChild(image);
		}
	}
	if( obj.class != null ) {
		for( var i=0; i<obj.class.length; i++ ) table.classList.add( obj.class[i] );
	}
	if( obj.id != null ) table.id=obj.id;
	
	if( obj.data != null ) {
		for( var key in obj.data ) SetDataAttribute(table, key, obj.data[key]);
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
		
		if( row.data != null ) {
			for( var key in row.data ) SetDataAttribute(tr, key, row.data[key]);
		}
		
		for(var j=0;j<obj.columns.length;j++) {
			var column=obj.columns[j];
			var td=document.createElement('td');
			if( column.class != null ) {
				for( var k=0; k<column.class.length; k++ ) td.classList.add( column.class[k] );
			}
			td.innerHTML=row.values[column.id];
			tr.appendChild(td);
		}
		if( buttoning==1 ) {
			tr.appendChild(ButtonsTd.cloneNode(true));
		}
		tbody.appendChild(tr);
	}
	table.appendChild(tbody);
	return table;
}

var DivToTable=document.getElementsByClassName('DivToTable');
for(var i=0;i<DivToTable.length;i++) {
	var table=JSON.parse(DivToTable[i].innerHTML);
	DivToTable[i].parentNode.replaceChild( RenderTable(table), DivToTable[i]);
}
