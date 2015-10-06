function RenderForm(obj) {
	var form = document.createElement('form');
	if (obj.id != null) form.id=obj.id;
	
	SetDataAttribute(form ,'SubmitFunction', obj.SubmitFunction);
	form.addEventListener('submit', function(e) {
		e.preventDefault();
		eval(GetDataAttribute(this, 'SubmitFunction'));
		return false;
	});
	
	var table = document.createElement('table');
	
	var TableHeader = document.createElement('thead');
	var TableHeaderTr = document.createElement('tr');
	
	for (var i = 0; i < obj.inputs.length; i++) {
		if (obj.inputs[i].type != 'hidden') {
			var th = document.createElement('th');
			th.innerHTML = obj.inputs[i].title;
			TableHeaderTr.appendChild(th);
		}
	}
	var SubmitTh = document.createElement('th');
	TableHeaderTr.appendChild(SubmitTh);
	
	TableHeader.appendChild(TableHeaderTr);
	table.appendChild(TableHeader);
	
	var MainTr = document.createElement('tr');
	
	for (var i = 0; i < obj.inputs.length; i++) {
		var InputObj = obj.inputs[i];
		var input;
		if (InputObj.type == 'AjaxSelect') {
			input = RenderSelect(InputObj.select);
		}
		else if (InputObj.type == 'date') {
			input = RenderDate(InputObj.date);
		}
		else {
			input = document.createElement('input');
			input.type = InputObj.type;
			input.name = InputObj.name;
			
			for (var property in InputObj) {
				if (InputObj.hasOwnProperty(property)) {
					if (property != 'type' && property != 'name') {
						input.setAttribute(property, InputObj[property]);
					}
				}
			}
		}
		if (InputObj.type == 'hidden') form.appendChild(input);
		else {
			var td = document.createElement('td');
			td.appendChild(input);
			MainTr.appendChild(td);
		}
	}
	var submit = document.createElement('input');
	submit.type = 'submit';
	if (obj.SubmitText != null) submit.value = obj.SubmitText;
	if (obj.SubmitId != null) submit.id = obj.SubmitId;
	MainTr.appendChild(submit);
	
	table.appendChild(MainTr);
	form.appendChild(table);
	
	var div = document.createElement('div');
	div.className = 'FormContainer';
	div.appendChild(form);
	
	return div;
}

//The variable TablesInformation is defined server-side
if (FormsInformation != null) {
	for (var i = 0; i < FormsInformation.length; i++) {
		var form = FormsInformation[i];
		var DivToForm = document.getElementById('DivToForm'+i);
		DivToForm.parentNode.replaceChild(RenderForm(form), DivToForm);
	}
}
