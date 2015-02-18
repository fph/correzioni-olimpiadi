var ItalianTranslation={modify:'Modifica', trash:'Elimina', confirm:'Conferma', cancel:'Annulla'};
var ImageSrc={
	modify	:'../View/Images/ModifyButton.png',
	trash	:'../View/Images/TrashButton.png',
	confirm	:'../View/Images/ConfirmButton.png',
	cancel	:'../View/Images/CancelButton.png',
	SendMail:'../View/Images/SendMail.png'
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
	ButtonSpan.classlist.add('ButtonContainer');
	ButtonSpan.classlist.add(ButtonContainerClass[type]);
	
	var button=document.createElement('image');
	button.classList.add('ButtonImage');
	button.classList.add(ButtonClass[type]);
	button.setAttribute('src', ImageSrc[type]);
	button.setAttribute('alt', ItalianTranslation[type]);
	button.setAttribute('title', ItalianTranslation[type]);
	
	ButtonSpan.appendChild(button);
	
	return ButtonSpan;
}

function ShowHideButton( container, type, show ) {
	if( show==true ) container.getElementsByClassName(ButtonContainerClass[type])[0].classList.remove('hidden');
	if( show==false ) container.getElementsByClassName(ButtonContainerClass[type])[0].classList.add('hidden');
}

function StartModifyingTitle() { //TODO: Queste due funzioni andrebbero riviste (forse anche spostare in alto
	var ButtonsTitle=document.getElementsByClassName('ButtonsTitle')[0];
	ShowHideButton(ButtonsTitle, 'modify', false);
	ShowHideButton(ButtonsTitle, 'trash', false);
	ShowHideButton(ButtonsTitle, 'confirm', true);
	ShowHideButton(ButtonsTitle, 'cancel', true);
}

function EndModifyingTitle() {
	var ButtonsTitle=document.getElementsByClassName('ButtonsTitle')[0];
	ShowHideButton(ButtonsTitle, 'modify', true);
	ShowHideButton(ButtonsTitle, 'trash', true);
	ShowHideButton(ButtonsTitle, 'confirm', false);
	ShowHideButton(ButtonsTitle, 'cancel', false);
}


function RenderButtons ( obj ) {
	var id=obj.id;
	var ContainerSpan=document.createElement('span');
	ContainerSpan.classList.add('ButtonsContainer');
	ContainerSpan.id=id;
	
	if( obj.title==true ) { //TODO: Questo forse andrebbe rivisto meglio!
		obj.buttons={
			modify: {onclick: 'ModifyTitle()'},
			trash: {onclick: 'DeleteTitle()'},
			confirm: {hidden: true, onclick: 'SendTitleModification()'},
			cancel: {hidden: true, onclick: 'CancelTitleModification()'}
		};
	}
	
	for( var type in obj.buttons ) {
		var ButtonObj=obj.buttons[type];
		var button=CreateButton(type); //TODO: Tutto quello che segue andrebbe spostato in CreateButton?
		if( ButtonObj.hidden==true ) button.classList.add('hidden');
		
		SetDataAttribute(button, 'onclick', ButtonObj.onclick);
		button.childNodes[0].addEventListener('click', function(e) {
			eval( GetDataAttribute( this, 'onclick' ) );
		} );
		ContainerSpan.appendChild(button);
	}
	
	return ContainerSpan;
}

//The variable ButtonsInformation is defined server-side
if( ButtonsInformation != null ){
	for(var i=0;i<ButtonsInformation.length;i++) {
		var button=DatesInformation[i];
		var DivToButton=document.getElementById('DivToButton'+i);
		DivToButton.parentNode.replaceChild( RenderButtons(button), DivToButton);
	}
}
