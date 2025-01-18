var FirstYear = 2000;
var LastYear = new Date().getFullYear() + 10;

function getTodayDate() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
    const day = String(today.getDate()).padStart(2, '0');

    return `${year}-${month}-${day}`;
}

function GetDayDom(container) {
	return container.getElementsByClassName('DateInputDay')[0];
}

function GetMonthDom(container) {
	return container.getElementsByClassName('DateInputMonth')[0];
}

function GetYearDom(container) {
	return container.getElementsByClassName('DateInputYear')[0];
}

function GetDateDom(container) {
	return container.getElementsByClassName('DateInputDate')[0];
}

function GetDateValue(id) {
	return GetDateDom(document.getElementById(id)).value;
}

function RecalculateDate(container) {
	var day = GetDayDom(container);
	var month = GetMonthDom(container);
	var year = GetYearDom(container);
	var date = GetDateDom(container);
	
	date.value=year.value+'-'+month.value+'-'+day.value;
	UpdateDaysNumber(container);
	SetDate(date.value, container);
}

function SetDate(DateString, container) {
	var day = GetDayDom(container);
	var month = GetMonthDom(container);
	var year = GetYearDom(container);
	var date = GetDateDom(container);
	
	var DateObj = ParseDate(DateString);
	if (MonthDaysNumber[DateObj.month] >= DateObj.day) day.selectedIndex=DateObj.day-1;
	else day.selectIndex=0;
	month.selectedIndex=DateObj.month-1;
	year.selectedIndex=DateObj.year-FirstYear;
	date.value=DateString;
}


function UpdateDaysNumber (container) {
	var day = GetDayDom(container);
	var month = GetMonthDom(container);
	var year = GetYearDom(container);
	
	day.innerHTML='';
	
	var num = MonthDaysNumber[parseInt(month.value)];
	if (parseInt(month.value) == 2 && parseInt(year.value)%4 == 0) num++;
	for (var i=1; i <= num; i++) {
		var OptionItem = document.createElement('option');
		var DayNumber = i.toString();
		if (DayNumber.length == 1)DayNumber='0'+DayNumber;
		OptionItem.value=DayNumber;
		OptionItem.innerHTML=i.toString();
		day.appendChild(OptionItem);
	}
}

function RenderDate (obj) {
	var id = obj.id;
	var ContainerSpan = document.createElement('span');
	ContainerSpan.classList.add('DateInputContainer');
	ContainerSpan.id=id;
	var InputHidden = document.createElement('input');
	InputHidden.setAttribute('type', 'hidden');
	InputHidden.classList.add('DateInputDate');
	if (obj.name != null) InputHidden.name = obj.name;
	InputHidden.value=getTodayDate();
	ContainerSpan.appendChild(InputHidden);
	var select = [];
	var XYZ = ['day', 'month', 'year'];
	for (var i=0; i<3; i++) {
		select[XYZ[i]]=document.createElement('select');
		select[XYZ[i]].classList.add('DateInput'+CFL(XYZ[i]));
		select[XYZ[i]].addEventListener('change', function() {
			RecalculateDate(this.parentNode);
		});
	}
	
	for (var i=FirstYear; i <= LastYear; i++) {
		var OptionItem = document.createElement('option');
		OptionItem.value=i.toString();
		OptionItem.innerHTML=i.toString();
		select['year'].appendChild(OptionItem);
	}
	
	for (var i=1; i <= 12; i++) {
		var OptionItem = document.createElement('option');
		var MonthNumber = i.toString();
		if (MonthNumber.length == 1)MonthNumber='0'+MonthNumber;
		OptionItem.value=MonthNumber;
		OptionItem.innerHTML=MonthName[i];
		select['month'].appendChild(OptionItem);
	}
	
	for (var i=0; i<3; i++) ContainerSpan.appendChild(select[XYZ[i]]);
	UpdateDaysNumber(ContainerSpan);
	SetDate(getTodayDate(), ContainerSpan);
	return ContainerSpan;
}

//The variable DatesInformation is defined server-side
if (DatesInformation != null) {
	for (var i=0; i<DatesInformation.length; i++) {
		var date = DatesInformation[i];
		var DivToDate = document.getElementById('DivToDate'+i);
		DivToDate.parentNode.replaceChild(RenderDate(date), DivToDate);
	}
}
