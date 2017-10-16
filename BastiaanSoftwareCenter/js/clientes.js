var presentador;

function onLoad()
{	
	presentador = new ClientesPresentador(this);
	crearGrid();
}

function crearGrid()
{
	grid = new GridReg("grid");	
	grid._columnas = [
	{longitud:100, 	titulo:"Id",   	alias:"id", alineacion:"I" }, 
	{longitud:200, 	titulo:"Nombre",   alias:"nombre", alineacion:"I" }, 
	{longitud:200, 	titulo:"Apellido Paterno",   alias:"apellidoPaterno", alineacion:"I" }	
	]

	grid._ajustarAltura = true;
	grid._colorRenglon1 = "#FFFFFF";	
	grid._colorRenglon2 = "#f8f2de";
	grid._colorEncabezado1 = "#FF6600";
	grid._colorEncabezado2 = "#FF6600";
	grid._colorLetraEncabezado = "#ffffff";
	grid._colorLetraCuerpo = "#000000";
	grid._regExtra=20;
	grid._presentacionGranTotal = "SI";
	grid.subscribirAEvento(this, "eventGridRowDoubleClick", grid_eventGridRowDoubleClick);
	grid.render();		
}

function grid_eventGridRowDoubleClick()
{
	document.getElementById("principal").style.display ="none";	
	document.getElementById("altaCambioDiv").style.display  = "block";
}

function btnAlta_onClick()
{
	document.getElementById("principal").style.display ="none";	
	document.getElementById("altaCambioDiv").style.display  = "block";
}

function btnBaja_onClick()
{
	
}

function btnCambio_onClick()
{
	
}

function btnConsulta_onClick()
{
	presentador.consultar();
}

function btnSalir_onClick()
{

}

function getNombreCompleto()
{
	return $('#nombreInput').val();
}

function setDatos(datos)
{
	this.grid._dataProvider = datos;	
	this.grid.render();
}