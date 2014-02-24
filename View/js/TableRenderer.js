function CreateButtonsTd( buttons ) {
	var ItalianTranslation={modify:'Modifica', trash:'Elimina', confirm:'Conferma', cancel:'Annulla'};
	ButtonsTd=document.createElement('td');
	ButtonsTd.classList.add('ButtonsTd');
	for(var i=0; i<buttons.length; i++) {
		var button=buttons[i];
		var name=button.name;
		image=document.createElement('img');
		image.setAttribute('src','../View/Images/'+CFL(name)+'Button.png');
		image.setAttribute('alt',ItalianTranslation[name]);
		image.setAttribute('title',ItalianTranslation[name]);
		SetDataAttribute(image,'name',name);
		image.classList.add('ButtonImage');
		image.classList.add(CFL(name)+'ButtonImage');
		if( button.hidden != null && button.hidden == 1 ) image.classList.add('hidden');
		image.addEventListener('click',function(e) {
			var ParentTable=this.parentNode.parentNode.parentNode.parentNode;
			eval( GetDataAttribute(ParentTable, GetDataAttribute(this,'name')+'_function')+'(this.parentNode.parentNode);' );
		} );
		ButtonsTd.appendChild(image);
	}
	return ButtonsTd;
}

function CreateRow( obj , row) {
	var tr=document.createElement('tr');
	if( obj.redirect != null ) {
		SetDataAttribute(tr, 'redirect_url', obj.redirect);
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
		if( row.values[column.id]==null ) td.innerHTML='-';
		else td.innerHTML=row.values[column.id];
		tr.appendChild(td);
	}
	if( obj.buttons !=null ) {
		tr.appendChild( CreateButtonsTd(obj.buttons) );
	}
	return tr;
}

function RenderTable( obj ) {
	var table=document.createElement('table');
	table.classList.add('InformationTable');
	SetDataAttribute(table,'table_object',JSON.stringify(obj));
	var redirecting=0;
	var url='';
	if( obj.redirect != null ) {
		redirecting=1;
		url=obj.redirect;
	}
	var buttoning=0;
	
	if( obj.buttons != null ) {
		buttoning=1;
		for(var i=0; i<obj.buttons.length; i++) {
			var button=obj.buttons[i];
			var name=button.name;
			SetDataAttribute(table,name+'_function',button.onclick);
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
		if( column.order != null && column.order == 1 ) {
			//Qui dovrei implementare il fatto che si possa ordinare in base a questa riga...
		}
		th.innerHTML=column.name;
		TableHeaderTr.appendChild(th);
	}
	if( buttoning ) {
		var ButtonContainerTh=document.createElement('th');
		ButtonContainerTh.classList.add('ButtonsTh');
		TableHeaderTr.appendChild( ButtonContainerTh );
	}
	TableHeader.appendChild(TableHeaderTr);
	table.appendChild(TableHeader);
	
	var tbody=document.createElement('tbody');
	for(var i=0;i<obj.rows.length;i++) {
		var row=obj.rows[i];
		tbody.appendChild( CreateRow(obj,row) );
	}
	table.appendChild(tbody);
	return table;
}

function AddRow( table , row , OrderBy ) {
	var obj=JSON.parse(GetDataAttribute(table,'table_object'));
	var NewRow=CreateRow( obj , row );
	NewRow.classList.add('NewRow');
	setTimeout(function(){ NewRow.classList.remove('NewRow'); },5000);
	if( OrderBy == null ) {
		obj.rows.push(row);
		table.childNodes[1].appendChild(NewRow);
	}
	else {
		var i=0;
		for(;i<obj.rows.length;i++) {
			if(obj.rows.values[OrderBy] > row.values[OrderBy]) break;
		}
		obj.rows.splice(i,0,row);
		if( i==obj.rows.length ) table.childNodes[1].appendChild(NewRow);
		else table.childNodes[1].childNodes[i].insertBefore(NewRow);
	}
	
	SetDataAttribute( table, 'table_object', JSON.stringify(obj) );
}

var DivToTable=document.getElementsByClassName('DivToTable');
for(var i=0;i<DivToTable.length;i++) {
	var table=JSON.parse(DivToTable[i].innerHTML);
	DivToTable[i].parentNode.replaceChild( RenderTable(table), DivToTable[i]);
}
