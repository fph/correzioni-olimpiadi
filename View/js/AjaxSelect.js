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
		OptionDiv.innerHTML=option.text;
		SetDataAttribute(OptionDiv,'value',option.value);
		OptionDiv.classList.add('AjaxSelectOption');
		
		OptionDiv.addEventListener('click', function(e) {
			var container=this.parentNode.parentNode;
			var text=this.innerHTML;
			var value=GetDataAttribute(this,'value');
			container.getElementsByClassName('AjaxSelectValue')[0].value=value;
			container.getElementsByClassName('AjaxSelectText')[0].value=text;
			CleanOptions( container.id );
		});
		
		OptionsDiv.appendChild( OptionDiv );
	}
}

function RenderSelect( id , url ) {
	var TextSelect = document.createElement('input');
	TextSelect.classList.add('AjaxSelectText');
	SetDataAttribute(TextSelect,'request_url',url);
	TextSelect.addEventListener('keyup', function(e) {
		var id=this.parentNode.id;
		var val=this.value;
		var url=GetDataAttribute(this,'request_url');
		MakeAjaxRequest(url,{id: id, str:val},ListOptions,1);
	});
	var ValueSelect= document.createElement('input');
	ValueSelect.classList.add('AjaxSelectValue');
	
	var ContainerDiv=document.createElement('div');
	ContainerDiv.id=id;
	ContainerDiv.classList.add('AjaxSelectContainer');
	var OptionsDiv=document.createElement('div');
	OptionsDiv.classList.add('AjaxSelectOptionsDiv');
	ContainerDiv.appendChild( TextSelect );
	ContainerDiv.appendChild( ValueSelect );
	ContainerDiv.appendChild( OptionsDiv );
	return ContainerDiv;
}
