function CleanOptions( id ) {
	var container=document.getElementById( id );
	var OptionsDiv=container.getElementsByClassName('AjaxSelectOptionsDiv')[0];
	while( OptionsDiv.firstChild ){
		OptionsDiv.removeChild( OptionsDiv.firstChild );
	}
}

function ListOptions( obj ) {
	var id=obj.id;
	var container=document.getElementById( id );
	var OptionsDiv=container.getElementsByClassName('AjaxSelectOptionsDiv')[0];
	CleanOptions( id );
	var options=obj.list;
	for( var i=0; i<options.length; i++ ) {
		var option=options[i];
		var OptionDiv=document.createElement('div');
		OptionDiv.innerHTML=option.OptionText;
		SetDataAttribute(OptionDiv,'value',option.value);
		SetDataAttribute(OptionDiv,'InputText', option.InputText);
		OptionDiv.classList.add('AjaxSelectOption');
		
		// Here the event is mousedown instead of click, as click is fired after blur whereas mousedown is fired before.
		OptionDiv.addEventListener('mousedown', function(e) {
			var container=this.parentNode.parentNode;
			var value=GetDataAttribute(this,'value');
			var text=GetDataAttribute(this,'InputText');
			container.getElementsByClassName('AjaxSelectValue')[0].value=value;
			container.getElementsByClassName('AjaxSelectText')[0].value=text;
		});
		
		OptionsDiv.appendChild( OptionDiv );
	}
}

function GetSelectSuggestions( input ){
	var id=input.parentNode.id;
	var val=input.value;
	var type=GetDataAttribute(input,'request_type');
	var LastString=GetDataAttribute(input,'last_string');
	if( LastString == val ) return;
	else SetDataAttribute(input,'last_string',val);
	
	if( val == '' ) CleanOptions(id);
	else MakeAjaxRequest('../Modify/SelectSuggestions.php',{id: id, str:val,type: type},ListOptions,1);
}

function RenderSelect( id , type ) {
	var TextSelect = document.createElement('input');
	TextSelect.classList.add('AjaxSelectText');
	SetDataAttribute(TextSelect,'request_type',type);
	SetDataAttribute(TextSelect,'last_string','');
	TextSelect.addEventListener('keyup', function(e){
		GetSelectSuggestions(this);
		var ValueInput=this.nextSibling;
		ValueInput.value='';
		this.classList.remove('AjaxSelectOptionGood');
		this.classList.remove('AjaxSelectOptionBad');
	});
	
	TextSelect.addEventListener('blur',function(e) {
		var TextInput=this;
		var ValueInput=this.nextSibling;
		var OptionsDiv=this.parentNode.getElementsByClassName('AjaxSelectOptionsDiv')[0];
		OptionsDiv.classList.add('hidden');
		if( ValueInput.value != '' ) TextInput.classList.add('AjaxSelectOptionGood');
		else if( TextInput.value != '' ) TextInput.classList.add('AjaxSelectOptionBad'); 
	});
	
	TextSelect.addEventListener('focus',function(e) {
		GetSelectSuggestions(this);
		var OptionsDiv=this.parentNode.getElementsByClassName('AjaxSelectOptionsDiv')[0];
		OptionsDiv.classList.remove('hidden');
		this.classList.remove('AjaxSelectOptionGood');
		this.classList.remove('AjaxSelectOptionBad');
	});
	
	var ValueSelect= document.createElement('input');
	ValueSelect.classList.add('AjaxSelectValue');
	
	var ContainerDiv=document.createElement('div');
	ContainerDiv.id=id;
	ContainerDiv.classList.add('AjaxSelectContainer');
	
	var OptionsDiv=document.createElement('div');
	OptionsDiv.classList.add('AjaxSelectOptionsDiv');
	OptionsDiv.classList.add('hidden');
	ContainerDiv.appendChild( TextSelect );
	ContainerDiv.appendChild( ValueSelect );
	ContainerDiv.appendChild( OptionsDiv );
	return ContainerDiv;
}

function GetSelectText( id ) {
	return document.getElementById(id).getElementsByClassName('AjaxSelectText')[0].value;
}

function GetSelectValue( id ) {
	return document.getElementById(id).getElementsByClassName('AjaxSelectValue')[0].value;
}

var DivToSelect=document.getElementsByClassName('DivToSelect');
for(var i=0;i<DivToSelect.length;i++) {
	var select=JSON.parse(DivToSelect[i].innerHTML);
	DivToSelect[i].parentNode.replaceChild( RenderSelect( select.id, select.type ), DivToSelect[i]);
}
