function GetTableObject( table ) {
	return JSON.parse( GetDataAttribute( table, 'table_object' ) );
}

function SetTableObject( table , obj ) {
	SetDataAttribute( table, 'table_object', JSON.stringify( obj ) );
}

function EntryInCsvStandard( value ) {
	str=(value!=null)?value.toString():'-';
	var result = str.replace(/"/g, '""');
	if (result.search(/("|,|\n)/g) >= 0) result = '"' + result + '"';
	return result;
}

function ExportTableToCsv( obj ) {
	var csv="";
	
	for(var i=0;i<obj.columns.length;i++) {
		csv+=EntryInCsvStandard( obj.columns[i].name );
		if( i!=obj.columns.length-1 ) csv+=',';
	}
	csv+='\n';
	for(var i=0;i<obj.rows.length;i++) {
		for(var j=0;j<obj.columns.length;j++) {
			csv+=EntryInCsvStandard( obj.rows[i].values[obj.columns[j].id] );
			if( j!=obj.columns.length-1 ) csv+=',';
		}
		csv+='\n';
	}
	
	var FileName="table.csv";
	var blob = new Blob( [csv], {type:'text/csv;charset=utf8;'} );
	
	if(navigator.msSaveBlob) { // IE 10+
		navigator.msSaveBlob(blob, FileName);
	}
	else {
		var link=document.createElement('a');
		link.setAttribute("href", window.URL.createObjectURL(blob));
		link.setAttribute("download", FileName);
		document.body.appendChild(link);
		link.click();
		document.body.removeChild(link);
	}
}

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
		tr.classList.add('CursorPointer');
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
		else if( column.type != null && column.type=='date' ) td.innerHTML=GetItalianDate( row.values[column.id] );
		else td.innerHTML=row.values[column.id];
		tr.appendChild(td);
	}
	if( obj.buttons !=null ) {
		tr.appendChild( CreateButtonsTd(obj.buttons) );
	}
	return tr;
}

//Splits a string for natural sorting ( AB120.txt -> 'AB', 120, '.txt' )
function SplitString( s ) {
	var res=[];
	var num=0;
	var str="";
	var ChunkType="null";
	for( var i=0; i<s.length; i++ ) {
		if( '0'<=s[i] && s[i]<='9' ) {
			if( ChunkType=="string" ) {
				res.push(str);
				str="";
			}
			ChunkType="number";
			num=10*num+parseInt(s[i]);
		}
		else {
			if( ChunkType=="number" ) {
				res.push(num);
				num=0;
			}
			ChunkType="string";
			str+=s[i];
		}
	}
	if( ChunkType=="number" ) res.push(num);
	if( ChunkType=="string" ) res.push(str);
	
	return res;
}

function StringCompare(a,b) {
	if(a==null && b==null) return 0;
	else if(a==null) return -1;
	else if(b==null) return 1;
	var x=SplitString( a.toLowerCase() );
	var y=SplitString( b.toLowerCase() );
	for( var i=0; i<Math.min(x.length, y.length); i++ ) {
		if( typeof(x[i])==typeof(y[i]) ) {
			if( x[i]!=y[i] ) return ((x[i]<y[i])?-1:1);
		}
		else return ( (typeof(x[i])=='number')?-1:1 );
	}
	if( x.length==y.length ) return 0;
	return ((x.length<y.length)?-1:1); //DA AGGIUSTARE!
}

function NumberCompare(a,b) {
	if(a==null && b==null) return 0;
	else if(a==null) return -1;
	else if(b==null) return 1;
	var x=parseFloat(a);
	var y=parseFloat(b);
	if( x==y ) return 0;
	return ((x<y)?-1:1);
}

function DateCompare(a,b) {
	if(a==null && b==null) return 0;
	else if(a==null) return -1;
	else if(b==null) return 1;
	var x=a;
	var y=b;
	if( x==y ) return 0;
	return ((x<y)?-1:1);
}

function SuperCompare(a,b,type) {
	if( type == 'String' ) return StringCompare(a,b);
	else if( type == 'number' ) return NumberCompare(a,b);
	else if( type == 'date' ) return DateCompare(a,b);
	else return StringCompare(a,b);
}

function SortRows( obj , ColumnId, ascending) {
	var type='string'; //Default type
	for(var i=0;i<obj.columns.length;i++) {
		if( obj.columns[i].id == ColumnId ){
			if( obj.columns[i].type != null ) type=obj.columns[i].type;
			break;
		}
	}
	
	obj.rows.sort( function(a,b) {
		return SuperCompare( a.values[ColumnId] , b.values[ColumnId] , type);
	} );
	
	if( ascending ) obj.rows.reverse();
}

function RenderTable( obj ) {
	//Initial rows ordering
	if( obj.InitialOrder != null ){
		var ascending = 0;
		if( obj.InitialOrder.ascending != null ) ascending=obj.InitialOrder.ascending;
		SortRows( obj , obj.InitialOrder.ColumnId, ascending );
		obj.InitialOrder=null;
	}
	
	//Table creating
	var table=document.createElement('table');
	table.classList.add('InformationTable');
	SetTableObject(table,obj);
	
	//Redirect table-property
	var redirecting=0;
	var url='';
	if( obj.redirect != null ) {
		redirecting=1;
		url=obj.redirect;
	}
	
	//Buttons
	var buttoning=0;
	
	if( obj.buttons != null ) {
		buttoning=1;
		for(var i=0; i<obj.buttons.length; i++) {
			var button=obj.buttons[i];
			var name=button.name;
			SetDataAttribute(table,name+'_function',button.onclick);
		}
	}
	
	//Class, Id and Data attributes
	if( obj.class != null ) {
		for( var i=0; i<obj.class.length; i++ ) table.classList.add( obj.class[i] );
	}
	if( obj.id != null ) table.id=obj.id;
	
	if( obj.data != null ) {
		for( var key in obj.data ) SetDataAttribute(table, key, obj.data[key]);
	}
	
	//Table header
	var TableHeader=document.createElement('thead');
	var TableHeaderTr=document.createElement('tr');
	for( var i=0;i<obj.columns.length;i++) {
		var column=obj.columns[i];
		var th=document.createElement('th');
		SetDataAttribute(th,'column_id',column['id']);
		if( column.class != null ) {
			for( var j=0; j<column.class.length; j++ ) th.classList.add( column.class[j] );
		}
		
		th.innerHTML=column.name;
		if( column.order != null && column.order == 1 ) {
			if( column.last_order==null ) obj.columns[i].last_order = 0;
			th.classList.add('ColumnWithOrder');
			th.addEventListener('click', function() {
				var tableX=this.parentNode.parentNode.parentNode;
				var ColumnId=GetDataAttribute(this,'column_id');
				var ascending;
				var objX=GetTableObject(tableX);
				for(var i=0 ; i<objX.columns.length ; i++){
					if( objX.columns[i].id==ColumnId ) {
						ascending=(objX.columns[i].last_order==0)?1:0;
						objX.columns[i].last_order=ascending;
						break;
					}
				}
				SetTableObject(tableX,objX);
				SortTableRows( tableX, ColumnId, ascending );
			});
			
			var SortImage=document.createElement('img');
			SortImage.setAttribute('src','../View/Images/SortColumn.png');
			SortImage.setAttribute('alt','Ordina');
			SortImage.setAttribute('title','Ordina');
			SortImage.classList.add('SortColumnImage');
			
			th.appendChild(SortImage);
		}
		TableHeaderTr.appendChild(th);
	}
	if( buttoning ) {
		var ButtonContainerTh=document.createElement('th');
		ButtonContainerTh.classList.add('ButtonsTh');
		TableHeaderTr.appendChild( ButtonContainerTh );
	}
	TableHeader.appendChild(TableHeaderTr);
	table.appendChild(TableHeader);
	
	
	//Export in csv button
	if( obj.ExportCsv==null || obj.ExportCsv==true ) {
		var tfoot=document.createElement('tfoot');
		var ExportCsvTr=document.createElement('tr');
		ExportCsvTr.classList.add('ExportCsv');
		
		var ExportCsvTd=document.createElement('td');
		ExportCsvTd.setAttribute('colspan',obj.columns.length);
		ExportCsvTd.classList.add('ExportCsv');
		
		var ExportCsvSpan=document.createElement('span');
		ExportCsvSpan.classList.add('ExportCsv');
		ExportCsvSpan.classList.add('CursorPointer');
		ExportCsvSpan.innerHTML='Esporta in csv';
		ExportCsvSpan.addEventListener('click',function(e) {
			var ParentTable=this.parentNode.parentNode.parentNode.parentNode;
			ExportTableToCsv( GetTableObject(ParentTable) );
		} );
		
		ExportCsvTd.appendChild(ExportCsvSpan);
		ExportCsvTr.appendChild(ExportCsvTd);
		tfoot.appendChild(ExportCsvTr);
		
		table.appendChild(tfoot); //tfoot must be appended BEFORE tbody
	}
	
	//Table body
	var tbody=document.createElement('tbody');
	for(var i=0;i<obj.rows.length;i++) {
		var row=obj.rows[i];
		tbody.appendChild( CreateRow(obj,row) );
	}
	table.appendChild(tbody);
	
	return table;
}

function AddRow( table , row , OrderBy ) {
	var obj=GetTableObject(table);
	var NewRow=CreateRow( obj , row );
	NewRow.classList.add('NewRow');
	setTimeout(function(){ NewRow.classList.remove('NewRow'); },5000);
	var tbody=table.childNodes[1];
	if( OrderBy == null ) {
		tbody.appendChild(NewRow);
		obj.rows.push(row);
	}
	else {
		var type=null;
		for(var j=0;j<obj.columns.length;j++) {
			if( obj.columns[j].id==OrderBy ){
				type=obj.columns[j].type;
				break;
			}
		}
		var i=0;
		for(;i<obj.rows.length;i++) {
			if( SuperCompare( obj.rows[i].values[OrderBy], row.values[OrderBy] , type ) == 1) break;
		}
		if( i==obj.rows.length ) tbody.appendChild(NewRow);
		else tbody.insertBefore(NewRow, tbody.childNodes[i]);
		obj.rows.splice(i,0,row);
	}
	
	SetTableObject(table, obj);
}

function RemoveRow( table , row ) {
	var obj=GetTableObject(table);
	var tbody=table.childNodes[1];
	var i=0;
	for(;i<tbody.childNodes.length;i++) {
		if( tbody.childNodes[i]==row ) break;
	}
	tbody.removeChild(row);
	obj.rows.splice(i,1);
	SetTableObject(table, obj);
}

function SortTableRows( table , ColumnId , ascending ) {
	var obj=GetTableObject(table);
	obj.InitialOrder={ColumnId:ColumnId, ascending: ascending};
	table.parentNode.replaceChild( RenderTable(obj), table );
}

//The variable TablesInformation is defined server-side
if( TablesInformation != null ){
	for(var i=0;i<TablesInformation.length;i++) {
		var table=TablesInformation[i];
		var DivToTable=document.getElementById('DivToTable'+i);
		DivToTable.parentNode.replaceChild( RenderTable(table), DivToTable);
	}
}
