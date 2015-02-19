var ItalianTranslation={
	modify:'Modifica',
	trash:'Elimina', 
	confirm:'Conferma', 
	cancel:'Annulla', 
	SendMail:'Invia email'
};

var ImageSrc={
	modify	:'../View/Images/ModifyButton.png',
	trash	:'../View/Images/TrashButton.png',
	confirm	:'../View/Images/ConfirmButton.png',
	cancel	:'../View/Images/CancelButton.png',
	SendMail:'../View/Images/MailButton.png'
};

var ButtonClass={
	modify	:'ModifyButtonImage',
	trash	:'TrashButtonImage',
	confirm	:'ConfirmButtonImage',
	cancel	:'CancelButtonImage',
	SendMail:'SendMailButtonImage',
};

var ButtonContainerClass={
	modify	:'ModifyButtonContainer',
	trash	:'TrashButtonContainer',
	confirm	:'ConfirmButtonContainer',
	cancel	:'CancelButtonContainer',
	SendMail:'SendMailButtonContainer',
};

function CreateButton( type ) {
	var ButtonSpan=document.createElement('span');
	ButtonSpan.classList.add('ButtonContainer');
	ButtonSpan.classList.add(ButtonContainerClass[type]);
	
	var button=document.createElement('img');
	button.classList.add('ButtonImage');
	button.classList.add(ButtonClass[type]);
	button.setAttribute('src', ImageSrc[type]);
	button.setAttribute('alt', ItalianTranslation[type]);
	button.setAttribute('title', ItalianTranslation[type]);
	
	ButtonSpan.appendChild(button);
	
	return ButtonSpan;
}

function ShowHideButton( container, type, show ) {
	if( container.getElementsByClassName(ButtonContainerClass[type]).length != 0 ) {
		if( show==true ) container.getElementsByClassName(ButtonContainerClass[type])[0].classList.remove('hidden');
		if( show==false ) container.getElementsByClassName(ButtonContainerClass[type])[0].classList.add('hidden');
	}
}

function RenderButtons ( obj ) {
	if( obj.title==true ) {
		obj.class=['ButtonsTitle'];
		obj.buttons={
			modify: {onclick: 'ModifyTitle()'},
			trash: {onclick: 'DeleteTitle()'},
			confirm: {hidden: true, onclick: 'SendTitleModification()'},
			cancel: {hidden: true, onclick: 'CancelTitleModification()'}
		};
	}
	else if( obj.table==true ) {
		for( var type in obj.buttons ) obj.buttons[type].onclick+='(this.parentNode.parentNode.parentNode.parentNode)';
	}
	
	var ContainerSpan=document.createElement('span');
	ContainerSpan.classList.add('ButtonsContainer');
	if( obj.id!= null ) ContainerSpan.id=obj.id;
	if( obj.class!=null ) {
		for(var i=0; i<obj.class.length; i++) ContainerSpan.classList.add(obj.class[i]);
	}
	
	for( var type in obj.buttons ) {
		var ButtonObj=obj.buttons[type];
		var button=CreateButton(type); //TODO: Tutto quello che segue andrebbe spostato in CreateButton?
		if( ButtonObj.hidden==true ) button.classList.add('hidden');
		
		
		SetDataAttribute(button, 'onclick', ButtonObj.onclick);
		button.childNodes[0].addEventListener('click', function(e) {
			eval( GetDataAttribute( this.parentNode, 'onclick' ) );
		} );
		
		if( type=='modify' ) {
			button.childNodes[0].addEventListener('click', function(e) {
				ShowHideButton(this.parentNode.parentNode, 'modify', false);
				ShowHideButton(this.parentNode.parentNode, 'trash', false);
				ShowHideButton(this.parentNode.parentNode, 'confirm', true);
				ShowHideButton(this.parentNode.parentNode, 'cancel', true);
			} );
		}
		else if( type=='confirm' || type=='cancel' ) {
			button.childNodes[0].addEventListener('click', function(e) {
				ShowHideButton(this.parentNode.parentNode, 'modify', true);
				ShowHideButton(this.parentNode.parentNode, 'trash', true);
				ShowHideButton(this.parentNode.parentNode, 'confirm', false);
				ShowHideButton(this.parentNode.parentNode, 'cancel', false);
			} );
		}
		
		ContainerSpan.appendChild(button);
	}
	
	return ContainerSpan;
}

//The variable ButtonsInformation is defined server-side
if( ButtonsInformation != null ){
	for(var i=0;i<ButtonsInformation.length;i++) {
		var button=ButtonsInformation[i];
		var DivToButtons=document.getElementById('DivToButtons'+i);
		DivToButtons.parentNode.replaceChild( RenderButtons(button), DivToButtons);
	}
}
