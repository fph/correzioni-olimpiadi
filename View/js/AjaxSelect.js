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
		
		OptionDiv.addEventListener('click', function(e) {
			var container=this.parentNode.parentNode;
			var value=GetDataAttribute(this,'value');
			var text=GetDataAttribute(this,'InputText');
			container.getElementsByClassName('AjaxSelectValue')[0].value=value;
			container.getElementsByClassName('AjaxSelectText')[0].value=text;
			CleanOptions( container.id );
		});
		
		OptionsDiv.appendChild( OptionDiv );
	}
}

function OnKeyUpOrFocus(e){
	var id=this.parentNode.id;
	var val=this.value;
	var type=GetDataAttribute(this,'request_type');
	var LastString=GetDataAttribute(this,'last_string');
	if( LastString == val ) return;
	else SetDataAttribute(this,'last_string',val);
	
	if( val == '' ) CleanOptions(id);
	else MakeAjaxRequest('../Modify/SelectSuggestions.php',{id: id, str:val,type: type},ListOptions,1);
}

function RenderSelect( id , type ) {
	var TextSelect = document.createElement('input');
	TextSelect.classList.add('AjaxSelectText');
	SetDataAttribute(TextSelect,'request_type',type);
	SetDataAttribute(TextSelect,'last_string','');
	TextSelect.addEventListener('keyup', OnKeyUpOrFocus);
	TextSelect.addEventListener('focus', OnKeyUpOrFocus);
	
	TextSelect.addEventListener('blur',function(e) {
		var el=this.parentNode.getElementsByClassName('AjaxSelectOptionsDiv')[0];
		setTimeout(function(){
			el.classList.add('hidden');
		},100);
	});
	
	TextSelect.addEventListener('focus',function(e) {
		var el=this.parentNode.getElementsByClassName('AjaxSelectOptionsDiv')[0];
		el.classList.remove('hidden');
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
