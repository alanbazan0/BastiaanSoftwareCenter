var dtCh= "/";
var minYear=1900;
var maxYear=2100;

//crea fechas asignando por default el día actual (con el icono de calendario)
elCreadorDeFechas = function (id){
	var date = new Date();
	document.getElementById(id).value =  date.getFullYear() + "/" + (date.getMonth() +1) + "/" + date.getDate();
	$.datepicker.setDefaults($.extend({showMontAfterYear: true}, $.datepicker.regional['es']));	
    $('#'+id).datepicker({ showOn:'button', buttonImage:'../COM/estilo/estacion/botones/calendario.svg', buttonImageOnly:true});
    $('#'+id).datepicker('option', {dateFormat:'dd/mm/yy'});
    
    
    
    
    
} 
//crea fechas asignando por default el día actual (con el icono de calendario)

function isInteger(s)
{
	var i;
	for (i = 0; i < s.length; i++){
		// Check that current character is number.
		var c = s.charAt(i);
		if (((c < "0") || (c > "9"))) return false;
	}
	// All characters are numbers.
	return true;
}

function stripCharsInBag(s, bag)
{
	var i;
	var returnString = "";
	// Search through string's characters one by one.
	// If character is not in bag, append to returnString.
	for (i = 0; i < s.length; i++){
		var c = s.charAt(i);
		if (bag.indexOf(c) == -1) returnString += c;
	}
	return returnString;
}

function daysInFebruary (year)
{
	// February has 29 days in any year evenly divisible by four,
	// EXCEPT for centurial years which are not also divisible by 400.
	return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}

/*
* funcion utulitaria para verificar dias
*/
function DaysArray(n)
{
	for (var i = 1; i <= n; i++){
		this[i] = 31;
		if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
		if (i==2) {this[i] = 29}
	}
	return this;
}

/*
* Reciba una fecha y nos confirma si esta en un fomato de dd/mm/yyyy
*/
function isDate(dtStr)
{
	var daysInMonth = DaysArray(12);
	var pos1=dtStr.indexOf(dtCh);
	var pos2=dtStr.indexOf(dtCh,pos1+1);
	var strDay=dtStr.substring(0,pos1);
	var strMonth=dtStr.substring(pos1+1,pos2);
	var strYear=dtStr.substring(pos2+1);
	strYr=strYear;
	if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1);
	if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1);
	for (var i = 1; i <= 3; i++) {
		if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
	}
	day=parseInt(strDay);
	month=parseInt(strMonth);
	year=parseInt(strYr);
	if (pos1==-1 || pos2==-1){
		alert("El formato de la fecha debe de ser : dd/mm/yyyy");
		return false;
	}
	if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
		alert("Por favor escriba un dia valido");
		return false;
	}
	if (strMonth.length<1 || month<1 || month>12){
		alert("Por favor escriba un mes valido.");
		return false
	}
	if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
		alert("Por favor escriba un año valido entre "+minYear+" y "+maxYear);
		return false;
	}
	if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
		alert("Por favor escriba una fecha valida.");
		return false;
	}
	return true;
}

/*
* convierte un tipo date al formato de dd/mm/yyyy
*/
function formatDate(d){
	var curr_date = d.getDate();
	var curr_month = d.getMonth()+1;
	var curr_year = d.getFullYear();
	var fecha = rellenaCeros(curr_date,2) + "/" + rellenaCeros(curr_month,2) + "/" + rellenaCeros(curr_year,4);
	return fecha;
}

/*
* compara dos fechas en formato de dd/mm/yyyy
*/
function compareDate(d1, d2){
	var arrDate1 = d1.split("/");
	var useDate1 = new Date(arrDate1[2], arrDate1[1]-1, arrDate1[0]);
	var arrDate2 = d2.split("/");
	var useDate2 = new Date(arrDate2[2], arrDate2[1]-1, arrDate2[0]);
	if(useDate1<useDate2){
		return -1;
	}
	if(useDate1>useDate2){
		return 1;
	}
	return 0;
}