/*
* recibe un arreglo de objetos y un propiedad y nos regresa una lista separada por coma con 
* los valores de esa propiedad para todos los objetos 
*/
function arrayToCSString(listaObjetos, strCampo) 
{
	var strObjetos ="";
	var ii = listaObjetos.length;
	for(var i = 0; i < ii ; i++){
		strObjetos+= listaObjetos[i][strCampo] + ",";
	}
	if(strObjetos.length >0){
		strObjetos= strObjetos.substring(0,strObjetos.length-1)
	}
	return strObjetos;
}

/*
* recibe un arreglo de objetos y un propiedad y nos regresa una lista separada por coma con 
* los valores de esa propiedad para todos los objetos 
*/
function primArrayToCSString(listaObjetos) 
{
	var strObjetos ="";
	var ii = listaObjetos.length;
	for(var i = 0; i < ii ; i++){
		strObjetos+= listaObjetos[i] + ", ";
	}
	if(strObjetos.length >0){
		strObjetos= strObjetos.substring(0,strObjetos.length-1)
	}
	return strObjetos;
}
/*
* recibe un arreglo de objetos y un propiedad y nos regresa un arreglo con 
* los valores de esa propiedad para todos los objetos 
*/
function arrayToArray(listaObjetos, strCampo) 
{
	var arrayString = new Array();
	var ii = listaObjetos.length;
	for(var i = 0; i < ii ; i++){
		arrayString.push(listaObjetos[i][strCampo]);
	}
	return arrayString;
}

/*
* convierte un un valor que contiene el numero de minutos a un formato de d hh mm
*/
function minutosADias(totalMinutos) 
{
	var concat ="";
	var tiempo =parseInt(totalMinutos);
	var dias=0;
	var horas=0;
	var minutos=0;
	if(Math.floor(tiempo/(60*24)) > 0){
		dias =(Math.floor(tiempo/(60*24))); 
	}
	if(Math.floor(tiempo/60) > 0){
		horas =Math.floor( (((tiempo/(60*24)) - (Math.floor(tiempo/(60*24))) )* 24 )  ); 
	}
	minutos = parseInt(tiempo%60);
	concat += dias.toString() + " d "
	if( horas.toString().length==2){
		concat+=horas.toString()+" : ";
	}else{
		concat+="0"+horas.toString()+" : ";
	}
	if( minutos.toString().length==2){
		concat+=minutos.toString();
	}else{
		concat+="0"+minutos.toString();
	}
	return concat;
}

/*
* recibe una cadena y el numero de ceros que tiene que medir la cadena, usada principalmente para convertir fechas a formatos de dos digitos
*/
function rellenaCeros(valor, noCeros) 
{
	var concat = valor;
	for(; concat.toString().length < noCeros;){
		concat="0"+concat.toString();
	}
	return concat;
}

/*
* recibe un objeto y nos regresa una lista en forma de arbol de sus atributos
*/
function muestraObjeto(objeto, raiz) 
{
	var concat = raiz + "<ul>";
	var i=1;
	for (valor in objeto){
		concat += "<li id='" + raiz + "." + i + "'>" + valor;
		if(isArray(objeto[valor]) == true || isObject(objeto[valor])== true){
			concat += " : " + muestraObjeto(objeto[valor], raiz + "." + i);
		}else{
			concat += " : " + objeto[valor];
		}
		concat += "</li>";
		i++;
	}
	concat += "</ul>";
	return concat;
}

/*
* nos dice si un objeto es un array
*/
function isArray(obj) {
   if (obj.constructor.toString().indexOf("Array") == -1)
      return false;
   else
      return true;
}

/*
* nos dice si un objeto es un array
*/
function isObject(obj) {
   if (obj.constructor.toString().indexOf("Object") == -1)
      return false;
   else
      return true;
}

/*
* alterna la visibilidad de un elemento
*/
function toggleVisible(id) {
	if (document.getElementById(id).style.display == "none"){
		document.getElementById(id).style.display = "block";
	}else{
   		document.getElementById(id).style.display = "none";
	}
}

/*
* nos muestra los datos como texto que podemos copiar y pegar
*/
function verDatos(datos) {
	document.getElementById('watch').innerHTML = datos;
}

/*
* agregar comas a un numero
*/
function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

/*
* nos regresa el navegador/dispositivo
*/
function checkUserAgent(vs) {
    var pattern = new RegExp(vs, 'i');
    return !!pattern.test(navigator.userAgent);
}


/*
* nos regresa las propiedades de la ventana
*/
function getWindow() {
    var ventana = new Object();
	var myWidth = 0, myHeight = 0;
	if( typeof( window.innerWidth ) == 'number' ) {
	  //Non-IE
	  myWidth = window.innerWidth;
	  myHeight = window.innerHeight;
	} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
	  //IE 6+ in 'standards compliant mode'
	  myWidth = document.documentElement.clientWidth;
	  myHeight = document.documentElement.clientHeight;
	} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
	  //IE 4 compatible
	  myWidth = document.body.clientWidth;
	  myHeight = document.body.clientHeight;
	}
	ventana.ancho =  myWidth;
	ventana.alto = myHeight;
    return ventana;
}

getNewSubmitForm = function(url){
	var form = document.createElement('form');
    document.body.appendChild(form);
    form.action = url;
    form.method = "post";
   // form.target = "_blank";
    return form;
}

createNewFormElement = function (formInput, elementName, elementValue) {
	var input = document.createElement('input');
	input.id = elementName;
	input.name = elementName;
	input.value = elementValue;
	input.style.display = 'none';
	formInput.appendChild(input);
	return input;
}

/*
 * escapa los codigos de html a caracteres especiales 
 */
escapeCharacters = function (cadena){
	var buffer = cadena + "";
	buffer = buffer.replace(/&ntilde;/g,"ñ");
	buffer = buffer.replace(/&Ntilde;/g,"Ñ");
	buffer = buffer.replace(/&aacute;/g,"á");
	buffer = buffer.replace(/&Aacute;/g,"Á");
	buffer = buffer.replace(/&eacute;/g,"é");
	buffer = buffer.replace(/&Eacute;/g,"É");
	buffer = buffer.replace(/&iacute;/g,"í");
	buffer = buffer.replace(/&Iacute;/g,"Í");
	buffer = buffer.replace(/&oacute;/g,"ó");
	buffer = buffer.replace(/&Oacute;/g,"Ó");
	buffer = buffer.replace(/&uacute;/g,"ú");
	buffer = buffer.replace(/&Uacute;/g,"Ú");
	buffer = buffer.replace(/&uuml;/g,"ü");
	buffer = buffer.replace(/&Uuml;/g,"Ü");
	buffer = buffer.replace(/&ouml;/g,"ö");
	buffer = buffer.replace(/&Ouml;/g,"Ö");
	return buffer;
}

/*
 * escapa los codigos de html a caracteres especiales 
 */
quitaAcentos = function (cadena){
	var buffer = cadena + "";
	buffer = buffer.replace(/&ntilde;/g,"ñ");
	buffer = buffer.replace(/&Ntilde;/g,"Ñ");
	buffer = buffer.replace(/&Agrave;/g,"À");	
	buffer = buffer.replace(/&aacute;/g,"á");
	buffer = buffer.replace(/&Aacute;/g,"Á");
	buffer = buffer.replace(/&Egrave;/g,"È");
	buffer = buffer.replace(/&eacute;/g,"é");
	buffer = buffer.replace(/&Eacute;/g,"É");
	buffer = buffer.replace(/&iacute;/g,"í");
	buffer = buffer.replace(/&Iacute;/g,"Í");
	buffer = buffer.replace(/&oacute;/g,"ó");
	buffer = buffer.replace(/&Oacute;/g,"Ó");
	buffer = buffer.replace(/&uacute;/g,"ú");
	buffer = buffer.replace(/&Uacute;/g,"Ú");
	buffer = buffer.replace(/&iquest;/g,"¿");
	buffer = buffer.replace(/&iexcl;/g,"¡");	
	buffer = buffer.replace(/&uuml;/g,"ü");
	buffer = buffer.replace(/&Uuml;/g,"Ü");
	buffer = buffer.replace(/&ouml;/g,"ö");
	buffer = buffer.replace(/&Ouml;/g,"Ö");
		
	return buffer;
}

/*
* unicamente nos permite capturar numeros enteros, se coloca en el evento onkeypress de un input text
*/
function soloNumeros(evt){
	//asignamos el valor de la tecla a keynum
	if(window.event){// IE
		keynum = evt.keyCode;
	}else{
		keynum = evt.which;
	}
	//comprobamos si se encuentra en el rango
	if(keynum>47 && keynum<58 || keynum==08){
		return true;
	}else{
		return false;
	}
}
function justNumbers(e){
var keynum = window.event ? window.event.keyCode : e.which;
if ((keynum == 8) || (keynum == 46))
return true;
 
return /\d/.test(String.fromCharCode(keynum));

}
/*
* unicamente nos permite capturar numeros flotantes, se coloca en el evento onkeypress de un input text
*/
function soloNumerosFlotantes(evt){
	//asignamos el valor de la tecla a keynum
	if(window.event){// IE
		keynum = evt.keyCode;
	}else{
		keynum = evt.which;
	}
	//comprobamos si se encuentra en el rango
	if(keynum>47 && keynum<58 || keynum==08 ||  keynum==46 ){
		return true;
	}else{
		return false;
	}
}

function copiaArray(original)
{
	var arreglo = [];
	var ii = original.length;
	for(var i = 0 ; i < ii ; i++){
		arreglo.push(original[i]);
	}
	return arreglo;
}

/*
* nos regresa si un numero es entero
*/
function isInt(x)
{
   var y=parseInt(x);
   if (isNaN(y)) return false;
   return x==y && x.toString()==y.toString();
}

/*
* copia las propiedades de un objeto a otro
*/
function copiaPropiedades_(fuente, objetivo)
{
	for (var propiedad in fuente){
		objetivo["_" + propiedad ] = fuente[propiedad];
	}
	return objetivo;
}

/*
* genera propiedades para un objeto en base a un array de objetos, cada objeto recibe el nombre de su campo id
*/
function arregloAPropiedades_(arreglo, objetivo, campoid)
{
	if( objetivo == null  || objetivo == undefined){
		objetivo = {};
	}
	var ii = arreglo.length;
	for (var i = 0; i < ii ; i++ ){
		objetivo["_" + arreglo[i][campoid] ] = arreglo[i];
	}
	return objetivo;
}

/*
* copia las propiedades de un objeto a otro
*/
function copiaPropiedades(fuente, objetivo)
{
	for (var propiedad in fuente){
		objetivo[propiedad ] = fuente[propiedad];
	}
	return objetivo;
}

/*
* genera propiedades para un objeto en base a un array de objetos, cada objeto recibe el nombre de su campo id
*/
function arregloAPropiedades(arreglo, objetivo, campoid)
{
	if( objetivo == null  || objetivo == undefined){
		objetivo = {};
	}
	var ii = arreglo.length;
	for (var i = 0; i < ii ; i++ ){
		objetivo[arreglo[i][campoid] ] = arreglo[i];
	}
	return objetivo;
}

function getDocHeight() {
    var D = document;
    return Math.max(
        Math.max(D.body.scrollHeight, D.documentElement.scrollHeight),
        Math.max(D.body.offsetHeight, D.documentElement.offsetHeight),
        Math.max(D.body.clientHeight, D.documentElement.clientHeight)
    );
}

/*
 * devuelve los caracteres especiales a codigos de html
 */
unEscapeCharacters = function (cadena)
{
	var buffer = cadena + "";
	buffer = buffer.replace(/&ntilde;/g,"ñ");
	buffer = buffer.replace(/&Ntilde;/g,"Ñ");
	buffer = buffer.replace(/&aacute;/g,"á");
	buffer = buffer.replace(/&Aacute;/g,"Á");
	buffer = buffer.replace(/&eacute;/g,"é");
	buffer = buffer.replace(/&Eacute;/g,"É");
	buffer = buffer.replace(/&iacute;/g,"í");
	buffer = buffer.replace(/&Iacute;/g,"Í");
	buffer = buffer.replace(/&oacute;/g,"ó");
	buffer = buffer.replace(/&Oacute;/g,"Ó");
	buffer = buffer.replace(/&uacute;/g,"ú");
	buffer = buffer.replace(/&Uacute;/g,"Ú");
	buffer = buffer.replace(/&uuml;/g,"ü");
	buffer = buffer.replace(/&Uuml;/g,"Ü");
	buffer = buffer.replace(/&ouml;/g,"ö");
	buffer = buffer.replace(/&Ouml;/g,"Ö");
	return buffer;
}

/*
* recibe un objeto de datos y lo regresa como string de json, con los datos apropiadamente escapados
*/
enviarDatos = function (objeto)
{
	var buffer = JSON.stringify(objeto);
	buffer = encodeURIComponent(buffer);
	return buffer;
}


var NAV = navigator.appName;
var esExplorer;
if (NAV=="Microsoft Internet Explorer") {
	esExplorer = true;
}else{
	esExplorer = false;
}

/*
* me formatea la fecha
*/
function formattedDate(date)
{
    var d = new Date(date || Date.now()),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [day, month, year].join('/');
}

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

/*
* esta funcion cambia una de la lista de ips publicas a ip local, primero extraemos la ip del navegador
* luego la buscamos en la lista de ips locales, si la encontramos hacemos el reemplazo
*/
function urlPublicaALocal(urlAnterior)
{
	var ipActual = window.location.host.split(":")[0];
	var ipsPublicas = listaOpcionesProceso.getOpcion(8).split(",");
	var ipsLocales = listaOpcionesProceso.getOpcion(9).split(",");
	var esLocal = -1;
	var ii = ipsLocales.length;
	for(var i=0; i<ii ; i++){
		if( ipsLocales[i] == ipActual ){
			esLocal = i;
			break;
		}
	}
	if(esLocal == -1){
		return urlAnterior;
	}else{
		var ipNueva = urlAnterior.replace( ipsPublicas[esLocal], ipsLocales[esLocal]);
		return ipNueva;
	}
}
