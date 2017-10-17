class Clientes
{		
	constructor(html)
	{
		this.html = html
		this.presentador = new ClientesPresentador(this);
	}
	onLoad()
	{			
		this.crearGrid();
	}
	
	crearGrid()
	{
		this.html.grid = new GridReg("grid");	
		this.html.grid._columnas = [
		{longitud:100, 	titulo:"Id",   	alias:"id", alineacion:"I" }, 
		{longitud:200, 	titulo:"Nombre",   alias:"nombre", alineacion:"I" }, 
		{longitud:200, 	titulo:"Apellido Paterno",   alias:"apellidoPaterno", alineacion:"I" }	
		]

		this.html.grid._ajustarAltura = true;
		this.html.grid._colorRenglon1 = "#FFFFFF";	
		this.html.grid._colorRenglon2 = "#f8f2de";
		this.html.grid._colorEncabezado1 = "#FF6600";
		this.html.grid._colorEncabezado2 = "#FF6600";
		this.html.grid._colorLetraEncabezado = "#ffffff";
		this.html.grid._colorLetraCuerpo = "#000000";
		this.html.grid._regExtra=20;
		this.html.grid._presentacionGranTotal = "SI";
		this.html.grid.subscribirAEvento(this, "eventGridRowDoubleClick", this.grid_eventGridRowDoubleClick);
		this.html.grid.render();		
	}
	
	btnConsulta_onClick()
	{
		this.presentador.consultar();
	}
	
	get nombreCompleto()
	{
		return $('#nombreInput').val();
	}

	set datos(valor)
	{
		this.html.grid._dataProvider = valor;	
		this.html.grid.render();
	}
	
	grid_eventGridRowDoubleClick()
	{
		$('#principal').hide()	
		$('#altaCambioDiv').show();
	}
	
}
var vista = new Clientes(this);

//var presentador;



/*
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
	//document.getElementById("principal").style.display ="none";	
	//document.getElementById("altaCambioDiv").style.display  = "block";
	
	$('#principal').hide()	
	$('#altaCambioDiv').show();
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

*/