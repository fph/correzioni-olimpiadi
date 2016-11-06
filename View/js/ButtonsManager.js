var ItalianTranslation = {
	modify		: 'Modifica',
	trash		: 'Elimina', 
	confirm		: 'Conferma', 
	cancel		: 'Annulla', 
	GoodMail	: 'Invia email',
	BadMail		: 'Invia email di non idoneità',
	GoodRemail	: 'Reinvia email',
	BadRemail	: 'Reinvia email di non idoneità',
};

var ImageSrc = {
	modify		: '../View/Images/ModifyButton.png',
	trash		: '../View/Images/TrashButton.png',
	confirm		: '../View/Images/ConfirmButton.png',
	cancel		: '../View/Images/CancelButton.png',
	GoodMail	: '../View/Images/GoodMailButton.png',
	BadMail		: '../View/Images/BadMailButton.png',
	GoodRemail	: '../View/Images/GoodRemailButton.png',
	BadRemail	: '../View/Images/BadRemailButton.png',
};

var ButtonClass = {
	modify		: 'ModifyButtonImage',
	trash		: 'TrashButtonImage',
	confirm		: 'ConfirmButtonImage',
	cancel		: 'CancelButtonImage',
	GoodMail	: 'MailButtonImage',
	BadMail		: 'MailButtonImage',
	GoodRemail	: 'RemailButtonImage',
	BadRemail	: 'RemailButtonImage',
};

var ButtonContainerClass = {
	modify		: 'ModifyButtonContainer',
	trash		: 'TrashButtonContainer',
	confirm		: 'ConfirmButtonContainer',
	cancel		: 'CancelButtonContainer',
	GoodMail	: 'MailButtonContainer',
	BadMail		: 'MailButtonContainer',
	GoodRemail	: 'RemailButtonContainer',
	BadRemail	: 'RemailButtonContainer',
};

function CreateButton(type) {
	var ButtonSpan = document.createElement('span');
	ButtonSpan.classList.add('ButtonContainer');
	ButtonSpan.classList.add(ButtonContainerClass[type]);
	
	var button = document.createElement('img');
	button.classList.add('ButtonImage');
	button.classList.add(ButtonClass[type]);
	button.setAttribute('src', ImageSrc[type]);
	button.setAttribute('alt', ItalianTranslation[type]);
	button.setAttribute('title', ItalianTranslation[type]);
	
	ButtonSpan.appendChild(button);
	
	return ButtonSpan;
}

function ShowHideButton(container, type, show) {
	if (container.getElementsByClassName(ButtonContainerClass[type]).length != 0) {
		if (show == true) container.getElementsByClassName(ButtonContainerClass[type])[0].classList.remove('hidden');
		if (show == false) container.getElementsByClassName(ButtonContainerClass[type])[0].classList.add('hidden');
	}
}

// obj might change in the function
function RenderButtons (obj) {
	if (obj.title == true) {
		obj.class=['ButtonsTitle'];
		obj.buttons={
			modify: {onclick: 'ModifyTitle()'},
			trash: {onclick: 'DeleteTitle()'},
			confirm: {hidden: true, onclick: 'SendTitleModification()'},
			cancel: {hidden: true, onclick: 'CancelTitleModification()'}
		};
	}
	
	if (obj.table == true) {
		for (var type in obj.buttons) {
			// The code is this as way in order to avoid repeated append of (this.parent...)
			// to onclick. 'TableModification' must be saved in obj.buttons[type]
			// as if it was saved in obj.buttons it would have broken the following lines.
			if (obj.buttons[type].TableModification == null) {
				obj.buttons[type].TableModification=true;
				obj.buttons[type].onclick+='(this.parentNode.parentNode.parentNode.parentNode)';
			}
		}
	}
	
	var ContainerSpan = document.createElement('span');
	ContainerSpan.classList.add('ButtonsContainer');
	if (obj.id != null) ContainerSpan.id=obj.id;
	if (obj.class != null) {
		for (var i=0; i<obj.class.length; i++) ContainerSpan.classList.add(obj.class[i]);
	}
	
	for (var type in obj.buttons) {
		var ButtonObj = obj.buttons[type];
		var button = CreateButton(type); //TODO: Tutto quello che segue andrebbe spostato in CreateButton?
		if (ButtonObj.hidden == true) button.classList.add('hidden');
		
		
		SetDataAttribute(button, 'onclick', ButtonObj.onclick);
		button.childNodes[0].addEventListener('click', function(e) {
			eval(GetDataAttribute(this.parentNode, 'onclick'));
		});
		
		if (type == 'modify') {
			button.childNodes[0].addEventListener('click', function(e) {
				ShowHideButton(this.parentNode.parentNode, 'modify', false);
				ShowHideButton(this.parentNode.parentNode, 'trash', false);
				ShowHideButton(this.parentNode.parentNode, 'confirm', true);
				ShowHideButton(this.parentNode.parentNode, 'cancel', true);
			});
		}
		else if (type == 'confirm' || type == 'cancel') {
			button.childNodes[0].addEventListener('click', function(e) {
				ShowHideButton(this.parentNode.parentNode, 'modify', true);
				ShowHideButton(this.parentNode.parentNode, 'trash', true);
				ShowHideButton(this.parentNode.parentNode, 'confirm', false);
				ShowHideButton(this.parentNode.parentNode, 'cancel', false);
			});
		}
		
		ContainerSpan.appendChild(button);
	}
	
	return ContainerSpan;
}

function ChangeMailToRemail(ButtonsContainer) {
	var MaybeGoodMailButtonSpan = ButtonsContainer.getElementsByClassName(ButtonContainerClass['GoodMail']);
	if (MaybeGoodMailButtonSpan.length > 0) {
		var MailButtonSpan = MaybeGoodMailButtonSpan[0];
		MailButtonSpan.classList.remove(ButtonContainerClass['GoodMail']);
		MailButtonSpan.classList.add(ButtonContainerClass['GoodRemail']);
		var button = MailButtonSpan.getElementsByTagName('img')[0]
		button.classList.remove(ButtonClass['GoodMail']);
		button.classList.add(ButtonClass['GoodRemail']);
		button.setAttribute('src', ImageSrc['GoodRemail']);
		button.setAttribute('alt', ItalianTranslation['GoodRemail']);
		button.setAttribute('title', ItalianTranslation['GoodRemail']);
	}
	var MaybeBadMailButtonSpan = ButtonsContainer.getElementsByClassName(ButtonContainerClass['GoodMail']);
	if (MaybeBadMailButtonSpan.length > 0) {
		var MailButtonSpan = MaybeBadMailButtonSpan[0];
		MailButtonSpan.classList.remove(ButtonContainerClass['BadMail']);
		MailButtonSpan.classList.add(ButtonContainerClass['BadRemail']);
		var button = MailButtonSpan.getElementsByTagName('img')[0]
		button.classList.remove(ButtonClass['BadMail']);
		button.classList.add(ButtonClass['BadRemail']);
		button.setAttribute('src', ImageSrc['BadRemail']);
		button.setAttribute('alt', ItalianTranslation['BadRemail']);
		button.setAttribute('title', ItalianTranslation['BadRemail']);
	}
}

//The variable ButtonsInformation is defined server-side
if (ButtonsInformation != null) {
	for (var i=0; i<ButtonsInformation.length; i++) {
		var button = ButtonsInformation[i];
		var DivToButtons = document.getElementById('DivToButtons'+i);
		DivToButtons.parentNode.replaceChild(RenderButtons(button), DivToButtons);
	}
}
